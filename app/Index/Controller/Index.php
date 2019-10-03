<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/13
 * Time: 0:41
 */

namespace app\Index\Controller;

use dcr\Request;
use dcr\DB;
use dcr\View;

class Index
{
    function index(){
        $view = container('view');
        $view->assign('version', config('info.version'));
        $view->assign('name', config('info.name'));
        return $view->render('index');
    }
}