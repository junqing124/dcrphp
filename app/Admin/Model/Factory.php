<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/21
 * Time: 0:29
 */

namespace app\Admin\Model;

use dcr\Session;
use \Exception;
use phpDocumentor\Reflection\DocBlockFactory;

class Factory
{
    /**
     * 输出后台页面 抽象出来 主要是为了做验证
     * @param $template
     * @param $dataList
     * @return mixed
     * @throws Exception
     */
    public static function renderPage($template, $dataList)
    {
        if (!$dataList['page_title']) {
            throw new Exception('请设置页面标题,参考 Admin->Index->Index->index()');
        }
        //判断有没有权限权限
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
