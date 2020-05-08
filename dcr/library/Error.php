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
    public static function init()
    {
        $request = container('request');
        $handler = '\Whoops\Handler\PrettyPageHandler';
        if ($request->isAjax()) {
            $handler = '\Whoops\Handler\JsonResponseHandler';
        }
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new $handler);
        $whoops->register();
    }
}
