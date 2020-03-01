<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/6
 * Time: 1:15
 */

namespace dcr;


class Db extends DcrBase
{

    private static $config = [];
    /**
     * @var null 实例
     */
    private static $instance = null;

    /**
     * 禁止实例化
     */
    private function __construct()
    {
    }

    /**
     * 禁止克隆
     */
    private function __clone()
    {
    }

    /**
     * @param $config 格式化配置
     * @return array 数据库配置
     */
    public static function formatConfig($config)
    {
        if (empty($config)) {
            $config = Config::_get('database.mysql.main');
        }
        return $config;
    }

    /**
     * @param array $config 配置
     * @param string $name 连接名
     * @return Db|null
     */
    public static function getInstance($config = [], $name = '')
    {
        $config = self::formatConfig($config);
        if (empty($name)) {
            $name = md5(serialize($config));
        }
        if(empty($config['driver'])){
            $config['driver'] = 'mysql';
        }

        $class = '\\dcr\\database\\connector\\' . ucwords($config['driver']);

        if (!isset(self::$instance[$name])) {
            self::$instance[$name] = new $class($config);
        }
        return self::$instance[$name];
    }

    /**
     * 调用数据底层处理
     * @param $method 方法
     * @param $params 参数
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([self::getInstance(), $method], $params);
    }
}