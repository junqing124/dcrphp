<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 11:50
 */

namespace dcr;


class Error
{
    static function init()
    {
        set_error_handler([__CLASS__, 'error']);
        set_exception_handler([__CLASS__, 'exception']);
    }

    /**
     * 异常接收
     * @access public
     * @param  \Exception|\Throwable $e 异常
     * @return void
     */
    public static function exception($e)
    {
        $view = container('view');
        $view->assign('eCode', $e->getCode());
        $view->assign('eFile', $e->getFile());
        $view->assign('eLine', $e->getLine());
        $view->assign('eMessage', $e->getMessage());
        $view->assign('eTrace', $e->getTraceAsString());
        $view->setViewDirectoryPath(ROOT_FRAME . DS . 'view');
        //dd($e->getTrace());
        echo  $view->render('exception');
        exit;
    }

    /**
     * 错误接收
     * @access public
     * @param  integer $errNo 错误编号
     * @param  integer $errStr 详细错误信息
     * @param  string $errFile 出错的文件
     * @param  integer $errLine 出错行号
     * @return void
     * @throws ErrorException
     */
    public static function error($errNo, $errStr, $errFile, $errLine)
    {
        if (in_array($errNo, array(E_USER_DEPRECATED, E_NOTICE, E_WARNING))) {
            return false;
        }
        $view = container('view');
        $view->assign('errNo', $errNo);
        $view->assign('errStr', $errStr);
        $view->assign('errFile', $errFile);
        $view->assign('errLine', $errLine);
        $view->setViewDirectoryPath(ROOT_FRAME . DS . 'view');
        echo  $view->render('error');
        exit;
    }
}