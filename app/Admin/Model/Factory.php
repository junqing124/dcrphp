<?php
/**
 * 本类用来做一些通用的function
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/21
 * Time: 0:29
 */

namespace app\Admin\Model;

use dcr\Session;
use app\Admin\Model\User;
use \Exception;
use phpDocumentor\Reflection\DocBlockFactory;

class Factory
{
    /**
     * 输出后台页面 抽象出来 主要是为了做验证
     * @param $template
     * @param $dataList
     * @param $templateViewDir 这里可以设置view目录，主要是为了兼容插件能设置自己的view目录
     * @return mixed
     * @throws Exception
     */
    public static function renderPage($template, $dataList, $templateViewDir = '')
    {
        if (!$dataList['page_title']) {
            throw new Exception('请设置页面标题,参考 Admin->Index->Index->index()');
        }
        if (!$dataList['page_model']) {
            throw new Exception('请设置本页模块,参考 Admin->Index->Index->index()');
        }
        $userId = session('userId');

        //权限系统具体文档可以看https://github.com/junqing124/dcrphp/wiki/%E6%9D%83%E9%99%90%E7%B3%BB%E7%BB%9F
        //如果是首页 则判断菜单权限
        if ('index/index' == $template && $userId) {
            $menu = require_once ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'Menu.php';
            //判断权限
            $user = new User();
            $permissionList = $user->getPermissionList(array('col' => 'name'));
            //系统的permission
            $permissionList = array_column($permissionList, 'name');
            //用户拥有的permission
            $permissionUserList = $user->getUserPermissionList($userId);
            foreach ($menu as $menu_key => $menu_detail) {
                //看看菜单 判断是不是有限制权限
                $title = '/' . $menu_detail['title'];
                if (in_array($title, $permissionList)) {
                    //看看有没有权限
                    if (!in_array($title, $permissionUserList)) {
                        unset($menu[$menu_key]);
                    } else {
                        //判断子的菜单
                        foreach ($menu_detail['sub'] as $menu_sub_key => $menu_sub_detail) {
                            //看看标题 判断是不是有限制权限
                            $title_sub = $title . '/' . $menu_sub_detail['title'];
                            if (in_array($title_sub, $permissionList)) {
                                //看看有没有权限
                                if (!in_array($title_sub, $permissionUserList)) {
                                    unset($menu[$menu_sub_key]);
                                } else {
                                }
                            } else {
                                continue;
                            }
                        }
                    }
                } else {
                    continue;
                }
            }
            $dataList['menu'] = $menu;
        }

        //判断function有没有被授权
        $permissionNameList = session('permissionNameList');
        //获取父function
        $functionList = debug_backtrace();
        $parentFunction = $functionList[1];
        if ($parentFunction) {
            //获取function的注释
            $reClass = new \ReflectionClass(new $parentFunction['class']);
            $functionDoc = $reClass->getMethod($parentFunction['function'])->getDocComment();
            if ($functionDoc) {
                //获取permission内容
                $factory = DocBlockFactory::createInstance();
                $docBlock = $factory->create($functionDoc);
                $permissionTag = $docBlock->getTagsByName('permission');
                if ($permissionTag) {
                    $permissionGeneric = current($permissionTag);
                    $permissionConfigName = $permissionGeneric->getDescription()->render();
                    //判断有无权限
                    if ($permissionConfigName && $permissionNameList) {
                        if (!in_array($permissionConfigName, $permissionNameList)) {
                            throw new \Exception("您没有[{$permissionConfigName}]权限，请联系系统管理员帮您开通后重新登陆");
                        }
                    }
                }
            }
        }

        //开始输出
        $view = container('view');
        //$view->outFormat = 'json';
        $admin = new Admin();
        if ($templateViewDir) {
            $admin->setViewDirectoryPath($templateViewDir);
        }
        $resultStr = $admin->common($view);
        $dataCommon = array('username' => Session::_get('username'));
        $dataList = array_merge($dataList, $dataCommon);
        if ($resultStr['ack']) {
            foreach ($dataList as $key => $data) {
                $view->assign($key, $data);
            }
            return $view->render($template);
        } else {
            return $view->render('login');
        }
    }

    /**
     * 输出json数据
     * @param $data
     * @param int $ignoreYz 是不是忽略验证 主要是改密码的时候要用下
     * @return mixed
     */
    public static function renderJson($data, $ignoreYz = 0)
    {
        $view = container('view');
        $view->outFormat = 'json';
        $admin = new Admin();
        if ($ignoreYz) {
            $loginResult = array('ack' => 1);
        } else {
            $loginResult = $admin->yz();
        }
        if (!$loginResult['ack']) {
            $result = $loginResult;
        } else {
            //验证成功
            $result = $data;
        }
        $view->data = $result;
        return $view->render();
    }
}
