<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use dcr\Session;
use dcr\Db;
use dcr\Safe;
use Respect\Validation\Validator as v;
use Aura\SqlQuery\QueryFactory;

class User
{

    /**
     * 获取用户名长度限制
     */
    function getUsernameLengthLimit()
    {
        return array('min' => 2, 'max' => 20);
    }

    /**
     * 获取密码长度限制
     */
    function getPasswordLengthLimit()
    {
        return array('min' => 6, 'max' => 20);
    }


    /**
     * 获取验证码长度限制
     */
    function getCaptchaLengthLimit()
    {
        return array('min' => 5, 'max' => 5);
    }

    /**
     * 验证用户信息
     * @param $username
     * @param $password 加密后的密码
     * @return array
     */
    function check($username, $password)
    {
        //$passwordJm = Safe::_encrypt($password);
        $sql = "select u_id,u_is_valid,zt_id from zq_user where u_username='{$username}' and u_password='{$password}' and zt_id>0";
        //echo $sql;
        $info = DB::query($sql);
        $result = array();
        if ($info) {
            $info = current($info);
            if ($info['u_is_valid']) {
                $result['ack'] = 1;
                $result['data'] = array(
                    'ztId' => $info['zt_id'],
                    'userId' => $info['u_id'],
                    'username' => $username,
                    'password' => $password,
                );
            } else {
                $result['ack'] = 0;
                $result['error_id'] = 1001;
                $result['msg'] = '用户已经被注销';
            }
        } else {
            $result['ack'] = 0;
            $result['error_id'] = 1000;
            $result['msg'] = '用户名或密码不正确';
        }
        /*dd($info);
        exit;*/
        return $result;
    }

    /**
     * 登陆用户
     * @param $ztId
     * @param $userId
     * @param $username
     * @param $password
     * @return true
     */
    function login($ztId, $userId, $username, $password)
    {
        Session::_set('ztId', $ztId);
        Session::_set('userId', $userId);
        Session::_set('username', $username);
        Session::_set('password', $password);
        return true;
    }

    /**
     * @return bool
     */
    function logout()
    {
        Session::_del('ztId');
        Session::_del('userId');
        Session::_del('username');
        Session::_del('password');
        return true;
    }

    /**
     * @param $info
     *
     * $info = array(
     * 'passwordNew'=> post('password_new'),
     * 'passwordNewRe'=> post('password_new_re'),
     * );
     * @param $user_id
     * @return array
     */
    function updatePassword($info, $user_id = '')
    {
        $passwordNew = $info['passwordNew'];
        $passwordNewRe = $info['passwordNewRe'];
        //验证
        $error = array();
        if (!v::equals($passwordNew)->validate($passwordNewRe)) {
            $error[] = '前后密码不一样';
        }

        $passwordLimit = $this->getPasswordLengthLimit();
        $stringValidator = v::stringType()->length($passwordLimit['min'], $passwordLimit['max']);
        if (!$stringValidator->validate($passwordNew)) {
            $error[] = '密码长度不符合';
        }

        if ($error) {
            return array('ack' => 0, 'msg' => $error);
        }
        //逻辑
        //如果有id就改id 没有就改当前用户的
        $where = '';
        if ($user_id) {
            $where = "u_id={$user_id}";
        } else {
            $where = "u_id=" . session('userId');
        }
        $result = DB::update('zq_user', array('u_password' => Safe::_encrypt($passwordNew), 'u_update_time' => time(), 'zt_id' => session('ztId')), $where);
        //dd($dbPre->getSql());
        //返回
        if (1 == $result) {

            return array('ack' => 1,);
        } else {
            //dd($dbPre->errorInfo());
            return array('ack' => 0, 'msg' => '添加到数据库时发生错误');
        }
    }

    /**
     * 添加编辑会员
     * @param $userInfo 格式如下
     * $userInfo = array(
     * 'u_username' => post('username'),
     * 'u_password' => post('password'),
     * 'u_sex' => post('sex'),
     * 'u_mobile' => post('mobile'),
     * 'u_tel' => post('tel'),
     * 'u_note' => post('note'),
     * 'u_add_time' => time(),
     * 'u_update_time' => time(),
     * );
     * @param string $type 添加还是编辑
     * @return array
     */
    function addEditUser($userInfo, $type = 'add')
    {
        $type = $type ? $type : 'add';
        //加上帐套id
        $error = array();
        $usernameLimit = $this->getUsernameLengthLimit();
        $passwordLimit = $this->getPasswordLengthLimit();
        //dd($type);
        if ('add' == $type) {
            $stringValidator = v::stringType()->length($usernameLimit['min'], $usernameLimit['max']);
            if (!$stringValidator->validate($userInfo['u_username'])) {
                //dd($stringValidator->validate($dbInfo['u_username']));
                $error[] = '用户名长度不符合';
            }
        }
        if ('add' == $type || ('edit' == $type && strlen($userInfo['u_password']))) {
            $stringValidator = v::stringType()->length($passwordLimit['min'], $passwordLimit['max']);
            if (!$stringValidator->validate($userInfo['u_password'])) {
                $error[] = '密码长度不符合';
            }
        }
        if (!v::in([1, 2])->validate($userInfo['u_sex'])) {
            $error[] = '性别选择有问题';
        }
        if ('add' == $type) {
            $queryFactory = new QueryFactory(config('database.mysql.main.driver'));
            //判断用户名有没有
            $select = $queryFactory->newSelect();
            $ztId = Session::_get('ztId');
            $select->from('zq_user')->cols(array('u_id'))->where("zt_id={$ztId} and u_username='{$userInfo['u_username']}'")->limit(1);
            $sql = $select->getStatement();
            $info = DB::query($sql);

            //dd($info);
            if ($info) {
                $error[] = '用户名已经被使用';
            }
        }
        if ($error) {
            return array('ack' => 0, 'msg' => $error);
        }
        //开始初始化数据
        $userInfo['zt_id'] = Session::_get('ztId');
        if ('add' == $type) {
            $userInfo['u_password'] = Safe::_encrypt($userInfo['u_password']);
            $userInfo['u_add_user_id'] = session('userId');
        } else if ('edit' == $type) {
            if ($userInfo['u_password']) {
                $userInfo['u_password'] = Safe::_encrypt($userInfo['u_password']);
            }
            $userInfo['u_edit_user_id'] = session('userId');
        }
        /*dd($type);
        dd($userInfo);
        exit;*/
        //逻辑
        $result = 0;
        if ('add' == $type) {
            //开始添加用户
            $result = DB::insert('zq_user', $userInfo);
        } else if ('edit' == $type) {
            $userId = $userInfo['u_id'];
            unset($userInfo['u_id']);
            unset($userInfo['u_username']);
            $result = DB::update('zq_user', $userInfo, "u_id={$userId}");
        }
        if (1 == $result) {

            return array('ack' => 1,);
        } else {
            return array('ack' => 0, 'msg' => '添加到数据库时发生错误');
        }
    }

    /**
     * @param $option 选项有order
     * @return mixed
     */
    function getList($option)
    {
        $option['table'] = 'zq_user';
        $list = DB::select($option);
        return $list;
    }

    /** 获取角色列表
     * @param $option
     * @return mixed
     */
    function getRoleList($option)
    {
        $option['table'] = 'zq_user_role';
        $list = DB::select($option);
        return $list;
    }

    /** 停止启用用户
     * @param $user_id
     * @param string $type
     * @return array
     */
    function startOrStop($user_id, $type = 'stop')
    {
        //验证
        $info = DB::select(array('table' => 'zq_user', 'col' => 'u_id', 'where' => "u_id={$user_id}", 'limit' => 1));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个用户');
        }
        //逻辑
        if ('start' == $type) {
            $dbInfo = array('u_is_valid' => 1);
        } else {
            $dbInfo = array('u_is_valid' => 0);
        }
        $result = DB::update('zq_user', $dbInfo, "u_id={$user_id}");
        //dd($dbPre->getSql());
        //返回
        if (1 == $result) {

            return array('ack' => 1,);
        } else {
            //dd($dbPre->errorInfo());
            return array('ack' => 0, 'msg' => '到数据库时发生错误');
        }
    }

    function delete($user_id)
    {
        //验证
        $info = DB::select(array('table' => 'zq_user', 'col' => 'u_id', 'where' => "u_id={$user_id}", 'limit' => 1));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个用户');
        }
        //逻辑
        $result = DB::delete('zq_user', "u_id={$user_id}");
        //dd($dbPre->getSql());
        //返回
        if (1 == $result) {

            return array('ack' => 1,);
        } else {
            //dd($dbPre->errorInfo());
            return array('ack' => 0, 'msg' => '到数据库时发生错误');
        }
    }
}