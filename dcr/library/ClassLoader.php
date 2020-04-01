<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 21:34
 */

namespace dcr;

class ClassLoader
{
    /**
     * 自动加载类
     * @param $className
     */
    public static function loadClasses($className)
    {
        if (empty($className)) {
            return;
        }
        //开始加载类
        if ('dcr\\' == substr($className, 0, 4)) {
            $classPath = LIB . DS . str_replace('dcr\\', '', $className) . '.php';
        }
        if ('app\\' == substr($className, 0, 4)) {
            $classPath = ROOT_FRAME . DS . '..' . DS . str_replace('dcr\\', '', $className) . '.php';
        }
        $classPath = str_replace('\\', DS, $classPath);

        try {
            if (file_exists($classPath)) {
                require_once $classPath;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 包含文件.
     * @param $file 文件名
     */
    public function includeFile($file)
    {
        include_once $file;
    }
}
