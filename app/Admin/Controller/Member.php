<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/21
 * Time: 22:54
 */

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\User;
use dcr\Page;

class Member
{
    function listMemberView()
    {
        $assignData = array();
        $whereStr = '';
        $where = array();
        //用户列表
        $user = new User();

        $username = get('u_username');
        if ($username) {
            $where['username'] = "u_username like '{$username}%'";
            $assignData['u_username'] = $username;
        }
        if ($where) {
            $whereStr = implode(' and ', $where);
        }
        //总数量
        $pageInfo = $user->getList(array('where' => $whereStr, 'col' => array('count(u_id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $user->getList(array('where' => $whereStr, 'order' => 'u_id desc', 'limit' => $pageNum, 'offset' => ($page - 1) * $pageNum));

        $assignData['page'] = $page;
        $assignData['user_num'] = $pageTotalNum;
        $assignData['users'] = $list;
        $assignData['pages'] = $pageHtml;

        return Factory::renderPage('member-list', $assignData);
    }

    function addOrEditView()
    {
        $user = new User();
        $usernameLimit = $user->getUsernameLengthLimit();
        $passwordLimit = $user->getPasswordLengthLimit();
        $data = array(
            'username_len_min' => $usernameLimit['min'],
            'username_len_max' => $usernameLimit['max'],
            'password_len_min' => $passwordLimit['min'],
            'password_len_max' => $passwordLimit['max'],
        );
        //如果是编辑用户 则要把用户信息传过去
        $user_id = get('user_id');
        if ($user_id) {
            $userInfo = $user->getList(array('col' => '*', 'where' => "u_id=" . $user_id));
            $userInfo = current($userInfo);
            $data['user_info'] = $userInfo;
            $data['user_id'] = $user_id;
        }
        return Factory::renderPage('member-add-edit', $data);
    }

    /**
     * 添加或修改用户
     * @return mixed
     */
    function addEditAction()
    {
        $userInfo = array(
            'u_username' => post('username'),
            'u_password' => post('password'),
            'u_sex' => post('sex'),
            'u_mobile' => post('mobile'),
            'u_tel' => post('tel'),
            'u_note' => post('note'),
            'u_add_time' => time(),
            'u_update_time' => time(),
        );
        //返回
        $user_id = post('user_id');
        if ($user_id) {
            $type = 'edit';
            $userInfo['u_id'] = $user_id;
        } else {
            $type = 'add';
        }
        //dd($type);
        //dd(get());
        $user = new User();
        $result = $user->addEditUser($userInfo, $type);
        return Factory::renderJson($result);
    }

    function passwordEditView()
    {
        return Factory::renderPage('member-password-edit', array());
    }

    function passwordEdit()
    {
        $user = new User();
        $info = array(
            'passwordNew' => post('password_new'),
            'passwordNewRe' => post('password_new_re'),
        );
        $result = $user->updatePassword($info);
        return Factory::renderJson($result, 1);
    }

    function stop()
    {
        $user = new User();
        $result = $user->startOrStop(post('id'), 'stop');
        return Factory::renderJson($result);
    }

    function start()
    {
        $user = new User();
        $result = $user->startOrStop(post('id'), 'start');
        return Factory::renderJson($result);
    }

    function delete()
    {
        $user = new User();
        $result = $user->delete(post('id'));
        return Factory::renderJson($result);
    }

    function changePasswordView()
    {
        $user = new User();
        $userInfo = $user->getList(array('col' => 'u_id,u_username', 'where' => "u_id=" . get('user_id')));
        $userInfo = current($userInfo);
        return Factory::renderPage('member-password-change', array('user_info' => $userInfo));
    }

    function changePassword()
    {
        $user = new User();
        $info = array(
            'passwordNew' => post('password_new'),
            'passwordNewRe' => post('password_new_re'),
        );
        $result = $user->updatePassword($info, post('user_id'));
        return Factory::renderJson($result, 1);
    }
}