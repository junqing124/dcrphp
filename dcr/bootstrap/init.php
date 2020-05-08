<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 21:07
 */
declare(strict_types = 1);

namespace dcr;

define('DS', DIRECTORY_SEPARATOR); //文件分隔符
define('ROOT_FRAME', dirname(__FILE__) . DS . '..'); //dcr目录
define('ROOT_APP', dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'app'); //app目录
define('ROOT_PUBLIC', ROOT_FRAME . DS . '..' . DS . 'public'); //public目录
define('LIB', ROOT_FRAME . DS . 'library');
define('START', microtime(true));
define('CONFIG_EXT', '.php');
define('CONFIG_DIR', ROOT_FRAME . DS . '..' . DS . 'config');
require_once ROOT_FRAME . DS . '..' . DS . 'vendor' . DS . 'autoload.php';
require_once ROOT_FRAME . DS . 'common' . DS . 'function.php';
require_once LIB . DS . 'ClassLoader.php';
require_once LIB . DS . 'App.php';
return App::init();
