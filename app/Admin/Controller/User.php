<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/21
 * Time: 22:54
 */

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\User as MUser;
use dcr\Page;
use dcr\Db;

class User
{

    private $model_name = '用户';
    /**
     * @permission /会员管理
     * @return mixed
     * @throws \Exception
     */
    public function listView()
    {
        $assignData = array();
        $assignData['page_title'] = '用户列表';
        $assignData['page_model'] = $this->model_name;
        $whereStr = '';
        $where = array();
        //用户列表
        $user = new MUser();

        $username = get('username');
        if ($username) {
            $where['username'] = "username like '{$username}%'";
            $assignData['username'] = $username;
        }
        //总数量
        $pageInfo = $user->getList(array('where' => $where, 'col' => array('count(id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $user->getList(array(
            'where' => $where,
            'order' => 'id desc',
            'limit' => $pageNum,
            'offset' => ($page - 1) * $pageNum
        ));

        $assignData['page'] = $page;
        $assignData['user_num'] = $pageTotalNum;
        $assignData['users'] = $list;
        $assignData['pages'] = $pageHtml;

        return Factory::renderPage('user/list', $assignData);
    }

    public function addRoleView()
    {
        $assignData['page_title'] = '添加角色';
        $assignData['page_model'] = $this->model_name;
        return Factory::renderPage('user/add-role', $assignData);
    }

    /**
     * 1.0.2开始废弃
     * @return mixed
     * @throws \Exception
     */
    public function addPermissionViewAbandon()
    {
        $assignData['page_title'] = '添加权限';
        $assignData['page_model'] = $this->model_name;
        return Factory::renderPage('user/add-permission', $assignData);
    }

    public function addRoleAjax()
    {
        $info = array(
            'name' => post('name'),
            'note' => post('note')
        );

        $user = new MUser();
        $result = $user->addRole($info);
        return Factory::renderJson($result);
    }

    /**
     * 1.0.2开始废弃
     * @return mixed
     */
    public function addPermissionAjax()
    {
        $info = array(
            'name' => post('name'),
        );

        $user = new MUser();
        $result = $user->addPermission($info);
        return Factory::renderJson($result);
    }

    /**
     * @permission /会员管理/会员添加
     * @return mixed
     * @throws \Exception
     */
    public function addOrEditView()
    {
        $user = new MUser();
        $usernameLimit = $user->getUsernameLengthLimit();
        $passwordLimit = $user->getPasswordLengthLimit();
        $assignData = array();
        $assignData = array(
            'username_len_min' => $usernameLimit['min'],
            'username_len_max' => $usernameLimit['max'],
            'password_len_min' => $passwordLimit['min'],
            'password_len_max' => $passwordLimit['max'],
        );
        //如果是编辑用户 则要把用户信息传过去
        $userId = get('user_id');
        if ($userId) {
            $userInfo = $user->getList(array('col' => '*', 'where' => "id=" . $userId));
            $userInfo = current($userInfo);
            $assignData['user_info'] = $userInfo;
            $assignData['user_id'] = $userId;

            //已经配置好的角色列表
            $roleList = $user->getRoleConfigList($userId);
            $roleKeys = array_keys(array_column($roleList, 'ur_id', 'ur_id'));
            $assignData['role_keys'] = $roleKeys;
        }
        //角色列表
        $roleConfigList = $user->getRoleList(array('col' => 'name,id'));

        $assignData['page_title'] = '密码更换';
        $assignData['page_model'] = $this->model_name;
        $assignData['role_config_list'] = $roleConfigList;

        return Factory::renderPage('user/add-or-edit', $assignData);
    }

    public function showView()
    {
        $user = new MUser();
        $user_id = get('user_id');
        $assignData = array();
        if ($user_id) {
            $userInfo = $user->getList(array('col' => '*', 'where' => "id=" . $user_id));
            $userInfo = current($userInfo);
            $assignData['user_info'] = $userInfo;
            $assignData['user_id'] = $user_id;
        }
        $assignData['page_title'] = '用户信息';
        $assignData['page_model'] = $this->model_name;
        return Factory::renderPage('user/show', $assignData);
    }

    /**
     * 添加或修改用户
     * @return mixed
     */
    public function addEditAjax()
    {
        $userInfo = array(
            'username' => post('username'),
            'password' => post('password'),
            'sex' => post('sex'),
            'mobile' => post('mobile'),
            'tel' => post('tel'),
            'note' => post('note'),
            'is_super' => post('is_super'),
            'roles' => post('roles'),
        );
        //返回
        $user_id = post('user_id');
        if ($user_id) {
            $type = 'edit';
            $userInfo['id'] = $user_id;
        } else {
            $type = 'add';
        }
        //dd($type);
        //dd(get());
        $user = new MUser();
        $result = $user->addEditUser($userInfo, $type);
        return Factory::renderJson($result);
    }

    public function passwordEditView()
    {
        $assignData = array();
        $assignData['page_title'] = '密码更换';
        $assignData['page_model'] = $this->model_name;
        return Factory::renderPage('user/password-edit', $assignData);
    }

    public function stopAjax()
    {
        $user = new MUser();
        $result = $user->startOrStop(post('id'), 'stop');
        return Factory::renderJson($result);
    }

    public function startAjax()
    {
        $user = new MUser();
        $result = $user->startOrStop(post('id'), 'start');
        return Factory::renderJson($result);
    }

    public function deleteAjax()
    {
        $user = new MUser();
        $result = $user->delete(post('id'));
        return Factory::renderJson($result);
    }

    public function passwordChangeView()
    {
        $user = new MUser();
        $userInfo = $user->getList(array('col' => 'id,username', 'where' => "id=" . get('user_id')));
        $userInfo = current($userInfo);
        $assignData = array();
        $assignData['user_info'] = $userInfo;
        $assignData['page_title'] = '密码更换';
        $assignData['page_model'] = $this->model_name;
        return Factory::renderPage('user/password-change', $assignData);
    }

    public function passwordChangeAjax()
    {
        $user = new MUser();
        $info = array(
            'passwordNew' => post('password_new'),
            'passwordNewRe' => post('password_new_re'),
        );
        $userId = post('user_id') ? post('user_id') : session('userId');
        $result = $user->updatePassword($info, $userId);
        return Factory::renderJson($result, 1);
    }

    /**
     * @permission /会员管理/角色编辑
     * @return mixed
     * @throws \Exception
     */
    public function roleView()
    {
        $user = new MUser();
        $list = $user->getRoleList(array());
        $assignData = array();
        $assignData['roles'] = $list;
        $assignData['page_title'] = '角色列表';
        $assignData['page_model'] = $this->model_name;

        return Factory::renderPage('user/role', $assignData);
    }

    /**
     * @permission /会员管理/权限列表
     * @return mixed
     * @throws \Exception
     */
    public function permissionView()
    {
        $user = new MUser();
        $list = $user->getPermissionList(array());
        $assignData = array();
        $assignData['permissions'] = $list;
        $assignData['page_title'] = '权限列表';
        $assignData['page_model'] = $this->model_name;

        return Factory::renderPage('user/permission', $assignData);
    }

    public function deleteRoleAjax()
    {
        $user = new MUser();
        $result = $user->deleteRole(post('id'));
        return Factory::renderJson($result);
    }

    /**
     * 1.0.2开始废弃
     * @return mixed
     */
    public function deletePermissionAjax()
    {
        $user = new MUser();
        $result = $user->deletePermission(post('id'));
        return Factory::renderJson($result);
    }

    public function roleEditPermissionView()
    {
        $user = new MUser();
        $roleId = get('role_id');
        //权限列表
        $list = $user->getPermissionList(array());
        //配置好的权限列表
        $roleConfig = $user->getRoleList(array('where' => 'id=' . $roleId));
        $rolePermissionIds = explode(',', $roleConfig[0]['permissions']);
        $assignData = array();
        $assignData['permissions'] = $list;
        $assignData['role_permission_ids'] = $rolePermissionIds;
        $assignData['role_id'] = $roleId;
        $assignData['page_title'] = '权限列表';
        $assignData['page_model'] = $this->model_name;

        return Factory::renderPage('user/role-edit-permission', $assignData);
    }

    public function roleEditPermissionAjax()
    {
        $user = new MUser();
        $result = $user->roleEditPermission(post());
        return Factory::renderJson($result);
    }
}
