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

class Factory
{
    /**
     * 输出后台页面 抽象出来 主要是为了做验证
     * @param $template
     * @param $dataList
     * @return mixed
     */
    static function renderPage($template, $dataList)
    {
        if( ! $dataList['page_title'] )
        {
            throw new Exception('请设置页面标题,参考 Admin->Index->Index->index()');
        }
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
    static function renderJson($data, $ignoreYz = 0)
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