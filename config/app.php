<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 20:09
 */
return [

    //别名
    'alias' => [
        'config'=> dcr\Config::class,
        'request'=> dcr\Request::class,
        'rule'=> dcr\route\Rule::class,
        'rule_item'=> dcr\route\RuleItem::class,
        'route'=> dcr\Route::class,
        'view'=> dcr\View::class,
        'response'=> dcr\Response::class,
    ],

    //时区
    'default_timezone' => 'PRC',

    //是不是debug模式
    'debug' => 0, //1是开启 0是关闭

    //数据库版本
    'db_driver' => 'mysql',

    //开启模板缓存
    'view_cache' => 0,

    //session过期时间
    'session_life_time'=> 3600,
];