<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

return array(
    'type' => env('DB_TYPE', ''),
    'mysql' =>
        array(
            'main' => array(
                'driver' => env('MYSQL_DB_DRIVER', 'mysql'),
                'host' => env('MYSQL_DB_HOST', '127.0.0.1'),
                'port' => env('MYSQL_DB_PORT', 3306),
                'database' => env('MYSQL_DB_DATABASE', 'zhanqun'),
                'username' => env('MYSQL_DB_USERNAME', 'root'),
                'password' => env('MYSQL_DB_PASSWORD', 'root'),
                'charset' => env('MYSQL_DB_CHARSET', 'utf8mb4'),
                'collation' => env('MYSQL_DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix' => env('MYSQL_DB_PREFIX', ''),
            ),
        ),
    'sqlite' =>
        array(
            'main' => array(
                'driver' => 'sqlite',
                'database' => '',
                'prefix' => '',
            )
        ),
);