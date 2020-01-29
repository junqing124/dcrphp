<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 14:04
 */

namespace app\Admin\Controller;

use app\Admin\Model\Config as MConfig;
use app\Admin\Model\Factory;
use app\Model\Define;
use dcr\Response;
use dcr\Session;
use dcr\View;
use app\Admin\Model\Admin;
use app\Admin\Model\User;
use dcr\Safe;

class Index
{
    function index()
    {
        /*dd($_SESSION);
        exit;*/
        $assignData = array();
        $version = config('info.version');
        $assignData['version'] = $version;
        $assignData['page_title'] = '首页';
        $modelList = Define::getModelDefine();
        $assignData['model_list'] = $modelList;
        return Factory::renderPage('index/index', $assignData);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    function welcome()
    {
        $assignData = array();
        $assignData['page_title'] = '欢迎页面';
        return Factory::renderPage('index/welcome', $assignData);
    }

    /**
     * 退出
     */
    function logout()
    {
        $user = new User();
        $user->logout();
        /*dd($_SESSION);
        exit;*/
        Response::_redirect('/admin/index/index');
    }

    /**
     * @param View $view
     * @return string
     * @throws \Throwable
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function login(View $view)
    {
        $assignData = array();
        $assignData['page_title'] = '登陆页';

        $username = post('username');
        $password = post('password');
        $captcha = post('captcha');
        $admin = new Admin();

        //判断验证码对不对
        if (Session::_get('captcha') != $captcha) {
            $view->assign('error_msg', '验证码不正确');
            $admin->common($view);
            return $view->render('login', $assignData);
        }
        //判断用户名

        $user = new User();
        $password = Safe::_encrypt($password);
        $yzResult = $user->check($username, $password);

        if ($yzResult['ack']) {
            //登陆后跳转
            $data = $yzResult['data'];
            $user->login($data['ztId'], $data['userId'], $data['username'], $data['password']);
            Response::_redirect('/admin/index/index');
        } else {
            $view->assign('error_msg', $yzResult['msg']);
            $admin->common($view);
            return $view->render('login', $assignData);
        }
    }
}