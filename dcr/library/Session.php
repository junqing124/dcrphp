<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 1:07
 */

namespace dcr;

class Session extends DcrBase
{

    /**
     * 初始化session
     */
    public static function init()
    {
        $life_time = \config('app.session_life_time');
        //dd($life_time);
        if ($life_time) {
            @ini_set('session.gc_maxlifetime', $life_time);
        }
        session_start();
    }

    /**
     * 获取session
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default = '')
    {
        return $_SESSION[$key] ? $_SESSION[$key] : $default;
    }

    /**
     * 设置session
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * 删除session
     * @param $key
     */
    public function del($key)
    {
        unset($_SESSION[$key]);
    }
}
