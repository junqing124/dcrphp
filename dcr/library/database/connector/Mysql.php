<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/31
 * Time: 1:33
 */

namespace dcr\database\connector;

use dcr\database\ConnectorDriver;

class Mysql extends ConnectorDriver
{
    /**
     * @var 配置
     */
    private $config;

    /**
     * Mysql constructor.
     * @param $config 配置
     * @throws
     */
    public function __construct($config)
    {
        $this->config = $config;

        //开始连接数据库
        $dsn = $this->getDsn();
        $username = $config['username'];
        $password = $config['password'];
        try {
            $pdo = new \PDO($dsn, $username, $password);
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            throw new \Exception('Could not connect to the database');
        }
    }

    /**
     * 返回连接串
     */
    public function getDsn()
    {
        $config = $this->config;
        $dsn = "mysql:dbname={$config['database']};host={$config['host']};port={$config['port']}";

        return $dsn;
    }

    public function __call($method, $args)
    {
        return call_user_func_array($method, $args);
    }
}
