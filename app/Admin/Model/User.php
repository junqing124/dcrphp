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
use phpDocumentor\Reflection\DocBlockFactory;
use Respect\Validation\Validator as v;
use Aura\SqlQuery\QueryFactory;
use Symfony\Component\Console\Style\SymfonyStyle;

class User
{

    /**
     * 获取用户名长度限制
     */
    public function getUsernameLengthLimit()
    {
        return array('min' => 2, 'max' => 20);
    }

    /**
     * 获取密码长度限制
     */
    public function getPasswordLengthLimit()
    {
        return array('min' => 6, 'max' => 20);
    }


    /**
     * 获取验证码长度限制
     */
    public function getCaptchaLengthLimit()
    {
        return array('min' => 5, 'max' => 5);
    }

    /**
     * 验证用户信息
     * @param $username
     * @param $password 加密后的密码
     * @return array
     */
    public function check($username, $password)
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
        //本代码不要删除，为了给TestWeb测试模块去除验证用
        /*dd($info);
        exit;*/
        return $result;
    }

    /**
     * 登陆用户
     * @param $userId
     * @return true
     */
    public function login($userId)
    {

        $userInfo = $this->getInfoById($userId);
        $ztId = $userInfo['zt_id'];
        $username = $userInfo['u_username'];
        $password = $userInfo['u_password'];

        $timeCur = time();
        $ip = getIp();
        $sql = "update zq_user set u_login_ip='{$ip}',u_login_count=u_login_count+1,u_login_time={$timeCur} where zt_id={$ztId} and u_username='{$username}'";
        DB::exec($sql);

        //记录权限
        $permissionNameList = $this->getUserPermissionList($userId);
        //dd($permissionIds);

        Session::_set('ztId', $ztId);
        Session::_set('userId', $userId);
        Session::_set('username', $username);
        Session::_set('password', $password);
        Session::_set('permissionNameList', $permissionNameList);
        return true;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        Session::_del('ztId');
        Session::_del('userId');
        Session::_del('username');
        Session::_del('password');
        Session::_del('permissionNameList');
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
    public function updatePassword($info, $user_id = '')
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
            return Admin::commonReturn(0, $error);
            //return array('ack' => 0, 'msg' => $error);
        }
        //逻辑
        //如果有id就改id 没有就改当前用户的
        $where = '';
        if ($user_id) {
            $where = "u_id={$user_id}";
        } else {
            $where = "u_id=" . session('userId');
        }
        $result = DB::update(
            'zq_user',
            array('u_password' => Safe::_encrypt($passwordNew), 'u_update_time' => time(), 'zt_id' => session('ztId')),
            $where
        );
        //dd($dbPre->getSql());
        //返回
        return Admin::commonReturn($result);
    }

    /**
     * 1.0.2开始废弃
     * @param array $permissionInfo 格式如下
     * $roleInfo = array(
     * 'ur_name' => post('name'), //必填
     * 'ur_note' => post('note'), //选填
     * );
     * @return array
     */
    public function addPermission(array $permissionInfo)
    {
        //验证
        $stringValidator = v::stringType()->length(1, 50);
        if (!$stringValidator->validate($permissionInfo['up_name'])) {
            $error[] = '角色长度不符合[1-50]';
        }

        //处理
        $permissionInfo['zt_id'] = Session::_get('ztId');
        $permissionInfo['up_add_time'] = time();
        $permissionInfo['up_update_time'] = time();
        $permissionInfo['up_add_user_id'] = session('userId');
        $result = DB::insert('zq_user_permission', $permissionInfo);
        //返回

        return Admin::commonReturn($result);
    }

    /**
     * @param array $roleInfo 格式如下
     * $roleInfo = array(
     * 'ur_name' => post('name'), //必填
     * 'ur_note' => post('note'), //选填
     * );
     * @return array
     */
    public function addRole(array $roleInfo)
    {
        //验证
        $stringValidator = v::stringType()->length(1, 50);
        if (!$stringValidator->validate($roleInfo['ur_name'])) {
            $error[] = '角色长度不符合[1-50]';
        }

        //处理
        $roleInfo['zt_id'] = Session::_get('ztId');
        $roleInfo['ur_add_time'] = time();
        $roleInfo['ur_update_time'] = time();
        $roleInfo['ur_permissions'] = '';
        $roleInfo['ur_add_user_id'] = session('userId') ? session('userId') : 0;
        $result = DB::insert('zq_user_role', $roleInfo);
        //返回

        return Admin::commonReturn($result);
    }

    /**
     * 添加编辑会员
     * @param array $userInfo 格式如下
     * $userInfo = array(
     * 'u_username' => post('username'), 必填
     * 'u_password' => post('password'), 必填
     * 'u_sex' => post('sex'), 必填 1或2
     * 'u_mobile' => post('mobile'),
     * 'u_tel' => post('tel'),
     * 'u_note' => post('note'),
     * );
     * @param string $type 添加还是编辑
     * @return array
     */
    public function addEditUser(array $userInfo, string $type = 'add')
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
        $ztId = $userInfo['zt_id'] ? $userInfo['zt_id'] : Session::_get('ztId');
        if ('add' == $type) {
            $queryFactory = new QueryFactory(config('database.mysql.main.driver'));
            //判断用户名有没有
            $select = $queryFactory->newSelect();
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
        $userInfo['zt_id'] = $ztId;
        $userInfo['u_update_time'] = time();

        $roles = $userInfo['roles'];
        unset($userInfo['roles']);

        if ('add' == $type) {
            $userInfo['u_add_time'] = time();
            $userInfo['u_password'] = Safe::_encrypt($userInfo['u_password']);
            $userInfo['u_add_user_id'] = session('userId') ? session('userId') : 0;
        } elseif ('edit' == $type) {
            if ($userInfo['u_password']) {
                $userInfo['u_password'] = Safe::_encrypt($userInfo['u_password']);
            } else {
                unset($userInfo['u_password']);
            }
            $userInfo['u_edit_user_id'] = session('userId');
        }
        /*dd($type);
        dd($userInfo);
        exit;*/
        //逻辑
        $result = 0;
        $userId = 0;
        if ('add' == $type) {
            //开始添加用户
            $result = DB::insert('zq_user', $userInfo);
            $userId = $result;
        } elseif ('edit' == $type) {
            $userId = $userInfo['u_id'];
            unset($userInfo['u_id']);
            unset($userInfo['u_username']);
            //清空角色
            DB::delete('zq_user_role_config', "urc_u_id={$userId} and zt_id={$userInfo['zt_id']}");
            //dd($userInfo);
            $result = DB::update('zq_user', $userInfo, "u_id={$userId}");
        }

        //开始更新用户角色
        if ($roles) {
            foreach ($roles as $roleKey) {
                //dd($roleKey);
                //先判断有没有
                $roleDbInfo = array(
                    'urc_add_time' => time(),
                    'urc_update_time' => time(),
                    'urc_add_user_id' => session('userId') ? session('userId') : 0,
                    'zt_id' => $userInfo['zt_id'],
                    'urc_u_id' => $userId,
                    'urc_r_id' => $roleKey,
                );
                //dd($roleDbInfo);
                DB::insert('zq_user_role_config', $roleDbInfo);
            }
        }

        return Admin::commonReturn($result);
    }

    /**
     * @param $option 选项有order
     * @return mixed
     */
    public function getList($option = array())
    {
        $option['table'] = 'zq_user';
        $list = DB::select($option);
        return $list;
    }

    public function getInfo($username)
    {
        $option['table'] = 'zq_user';
        $option['where'] = "u_username='{$username}'";
        $list = DB::select($option);
        $list = current($list);
        return $list;
    }

    public function getInfoById($id)
    {
        $option['table'] = 'zq_user';
        $option['where'] = "u_id='{$id}'";
        $list = DB::select($option);
        $list = current($list);
        return $list;
    }

    /** 获取角色列表
     * @param $option
     * @return mixed
     */
    public function getRoleList($option = array())
    {
        $option['table'] = 'zq_user_role';
        $list = DB::select($option);
        return $list;
    }

    /** 获取用户配置好的角色列表
     * @param $userId
     * @return mixed
     */
    public function getRoleConfigList($userId)
    {
        $option['table'] = 'zq_user_role_config';
        if ($userId) {
            $option['where'] = "urc_u_id={$userId}";
        }
        $list = DB::select($option);
        return $list;
    }


    public function getPermissionList($option = array())
    {
        $option['table'] = 'zq_user_permission';
        $option['order'] = 'up_name asc';
        $list = DB::select($option);
        return $list;
    }

    /**
     * 获取用户的权限列表
     * @param $userId
     * @return array
     */
    public function getUserPermissionList($userId)
    {
        $userInfo = $this->getInfoById($userId);
        $permissionNameList = array();
        //超级用户有全部权限
        if ($userInfo['u_is_super']) {
            $permissionNameList = $this->getPermissionList(array('col' => 'up_name',));
            $permissionNameList = array_column($permissionNameList, 'up_name');
        } else {
            //先得出角色名
            $roleList = $this->getRoleConfigList($userId);
            $permissionNameList = array();
            if ($roleList) {
                $roleIds = implode(',', array_column($roleList, 'urc_r_id', 'urc_r_id'));

                $permissionList = $this->getRoleList(array('where' => "ur_id in({$roleIds})"));
                if ($permissionList) {
                    $permissionIds = implode(',', array_column($permissionList, 'ur_permissions', 'ur_permissions'));
                    $permissionNameList = $this->getPermissionList(array(
                        'col' => 'up_name',
                        'where' => "up_id in({$permissionIds})"
                    ));
                    $permissionNameList = array_column($permissionNameList, 'up_name');
                }
            }
        }
        return $permissionNameList;
    }

    /** 停止启用用户
     * @param $userId
     * @param string $type
     * @return array
     */
    public function startOrStop($userId, $type = 'stop')
    {
        //验证
        $info = DB::select(array('table' => 'zq_user', 'col' => 'u_id', 'where' => "u_id={$userId}", 'limit' => 1));
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
        $result = DB::update('zq_user', $dbInfo, "u_id={$userId}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    public function delete($userId)
    {
        //验证
        $info = DB::select(array('table' => 'zq_user', 'col' => 'u_id', 'where' => "u_id={$userId}", 'limit' => 1));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个用户');
        }
        //逻辑
        $result = DB::delete('zq_user', "u_id={$userId}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    public function deleteRole($roleId)
    {
        //验证
        $info = DB::select(array(
            'table' => 'zq_user_role',
            'col' => 'ur_id',
            'where' => "ur_id={$roleId}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个信息');
        }
        //逻辑
        $result = DB::delete('zq_user_role', "ur_id={$roleId}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    /**
     * 1.0.2开始废弃
     * @param $permissionId
     * @return array
     */
    public function deletePermission($permissionId)
    {
        //验证
        $info = DB::select(array(
            'table' => 'zq_user_permission',
            'col' => 'up_id',
            'where' => "up_id={$permissionId}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个信息');
        }
        //逻辑
        $result = DB::delete('zq_user_permission', "up_id={$permissionId}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    public function roleEditPermission($data)
    {
        $roleId = $data['id'];
        if (!$data['up_id']) {
            throw new \Exception('请选择权限');
        }
        $permissionIds = implode(',', $data['up_id']);
        $dbInfo = array(
            'ur_permissions' => $permissionIds,
        );
        $result = DB::update('zq_user_role', $dbInfo, "ur_id={$roleId}");

        return Admin::commonReturn($result);
    }

    /**
     * 本function用来用注释生成权限
     * @return array
     * @throws \Exception
     */
    public function permissionRefresh()
    {
        //根据app\Admin来生成权限列表
        $dirList = array(
            ROOT_APP . DS . 'Admin' . DS . 'Controller',
        );
        $permissionList = array();
        foreach ($dirList as $dir) {
            $fileList = scandir($dir);
            foreach ($fileList as $fileName) {
                if (in_array($fileName, array('.', '..'))) {
                    continue;
                }
                $filePath = $dir . DS . $fileName;
                $factory = DocBlockFactory::createInstance();
                $docBlock = $factory->create(file_get_contents($filePath));
                $permissionTag = $docBlock->getTagsByName('permission');
                foreach ($permissionTag as $permissionGeneric) {
                    $permissionConfigName = $permissionGeneric->getDescription()->render();
                    //判断格式
                    if (substr($permissionConfigName, 1) == '/' || substr($permissionConfigName, -1) == '/') {
                        throw new \Exception($permissionConfigName . '  不规范,权限名请以/开头，结尾不要/，且以一个/做分隔');
                    }
                    if (preg_match("/\/{2,}/u", $permissionConfigName, $out)) {
                        throw new \Exception($permissionConfigName . '  不规范,权限名请以/开头，结尾不要/，且以一个/做分隔');
                    }
                    $permissionList[] = $permissionConfigName;
                }
            }
        }
        if (!$permissionList) {
            throw new \Exception('Find nothing permission config');
        }
        //判断有没有重复的
        $permissionListNew = array_unique($permissionList);
        if (count($permissionListNew) != count($permissionList)) {
            throw new \Exception('Find the same permission config,one is ' . implode(',', $permissionListNew) . ',two is' . implode(',', $permissionList));
        }
        //添加到权限表中
        //定义一个版本号，如果没有，则说明不是本次更新，删除之
        $version = uniqid();
        foreach ($permissionList as $permissionName) {
            $dbInfo = array(
                'up_update_time' => time(),
                'up_name' => $permissionName,
                'up_version' => $version,
                'up_add_user_id'=> 0,
                'zt_id' => session('ztId'),
            );
            $hasInfo = DB::select(array(
                'table' => 'zq_user_permission',
                'col' => 'up_id',
                'where' => "up_name='{$permissionName}'"
            ));
            //判断有没有
            if (!$hasInfo) {
                $dbInfo['up_add_time'] = time();
                $result = DB::insert('zq_user_permission', $dbInfo);
            } else {
                $hasInfo = current($hasInfo);
                $result = DB::update('zq_user_permission', $dbInfo, "up_id={$hasInfo['up_id']}");
            }
        }
        //非本版本的删除 这样做的原因是删除那些已经删除的权限
        DB::delete('zq_user_permission', "up_version!='{$version}'");

        return Admin::commonReturn($result);
    }
}
