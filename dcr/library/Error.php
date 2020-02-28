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
     * @param \Exception|\Throwable $e 异常
     * @return void
     */
    public static function exception($e)
    {
        if ('cli' == APP::$phpSapiName) {
            echo "Code:" . $e->getCode() . "\r\n";
            echo "File:" . $e->getFile() . "\r\n";
            echo "Line:" . $e->getLine() . "\r\n";
            echo "Message:" . $e->getMessage() . "\r\n";
            echo "Trace:" . $e->getTraceAsString() . "\r\n";
        }else{
            $view = container('view');
            $view->assign('e_code', $e->getCode());
            $view->assign('e_file', $e->getFile());
            $view->assign('e_line', $e->getLine());
            $view->assign('e_message', $e->getMessage());
            $view->assign('e_trace', $e->getTraceAsString());
            $view->setViewDirectoryPath(ROOT_FRAME . DS . 'view');
            //dd($e->getTrace());
            echo $view->render('exception');
        }
        exit;
    }

    /**
     * 错误接收
     * @access public
     * @param integer $errNo 错误编号
     * @param integer $errStr 详细错误信息
     * @param string $errFile 出错的文件
     * @param integer $errLine 出错行号
     * @return void
     * @throws ErrorException
     */
    public static function error($errNo, $errStr, $errFile, $errLine)
    {
        if (in_array($errNo, array(E_USER_DEPRECATED, E_NOTICE, E_WARNING))) {
            return false;
        }
        if ('cli' == APP::$phpSapiName) {
            echo "No:" . $errNo . "\r\n";
            echo "Str:" . $errStr . "\r\n";
            echo "File:" . $errFile . "\r\n";
            echo "Line:" . $errLine . "\r\n";
        }else{
            $view = container('view');
            $view->assign('err_no', $errNo);
            $view->assign('err_str', $errStr);
            $view->assign('err_file', $errFile);
            $view->assign('err_line', $errLine);
            $view->setViewDirectoryPath(ROOT_FRAME . DS . 'view');
            echo $view->render('error');
        }
        exit;
    }
}