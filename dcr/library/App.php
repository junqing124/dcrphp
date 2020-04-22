<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

namespace dcr;

use dcr\Route\RuleItem;

class App
{
    /**
     * @var $phpSapiName php运行模式
     */
    public static $phpSapiName;
    /**
     * 自动加载类
     */
    public static function autoLoadClasses()
    {
        spl_autoload_register(array('\dcr\ClassLoader', 'loadClasses'), true, true);
    }

    public static function init()
    {
        self::$phpSapiName = php_sapi_name();
        self::autoLoadClasses();
        Error::init();
        Env::init();
        $container = container();
        //加载配置
        $config = $container->make(\dcr\Config::class);
        $config->loadConfig();
        $container->instance(\dcr\Config::class, $config);
        $container->autoBind();
        Session::init();
        // set default zt_id
        Session::_set('ztId', 1);

        //程序测试与否
        if (config('app.debug')) {
            error_reporting(E_ALL ^ E_NOTICE ^  E_WARNING);
            @ini_set('display_errors', 'On');
        } else {
            @ini_set('display_errors', 'Off');
        }

        //设置时区
        date_default_timezone_set(config('app.default_timezone'));

        //如果是命令行就直接返回
        $result = '';
        if ('cli' == APP::$phpSapiName) {
            $result = '';
        }else
        {
            //开始处理request
            $request = Request::getInstance();
            $container->instance('request', $request);

            $route = container('route');
            //把url解析为ruleItem
            $ruleItem = $route->addRuleFromRequest($request);

            $result = self::exec($ruleItem);
        }

        return new Response($result);
    }

    public static function exec(RuleItem $ruleItem)
    {
        //去除action里面的-
        $action = $ruleItem->action;

        //把use-explain转成useExplain
        //把use-explain-vew转成useExplainView
        //把use留为use
        $actionArr = explode('-', $action);
        $actionList = [];
        foreach ($actionArr as $key => $actionStr) {
            $actionList[$key] = ucfirst($actionStr);
        }
        $action = implode('', $actionList);
        $action = lcfirst($action);

        //得出类来
        $model = ucfirst($ruleItem->model);
        $controller = ucfirst($ruleItem->controller);

        //类名
        $class = "\\app\\{$model}\\Controller\\{$controller}";

        try {
            $classObj = new $class;
            if (is_callable([$classObj, $action])) {
                //获取当前操作方法的参数列表 如果有类就实例化一个
                $reflect = new \ReflectionMethod($classObj, $action);
                $dependencies = container()->resolveConstructor($reflect->getParameters());
                $data = $reflect->invokeArgs($classObj, $dependencies);
            } else {
                throw new \Exception('Not find the function[' . $action . '] or model[' . $class . ']');
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }
}
