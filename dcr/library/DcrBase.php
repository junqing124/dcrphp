<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/4
 * Time: 1:10
 */

namespace dcr;

/**
 * Class DcrBase
 * 本类是基类，比如可以把一般function变是静态方法 比如getInfo 可以变为_getInfo
 * 还有允许指定的属性设置获取
 * @package dcr
 */
abstract class DcrBase
{
    /**
     * @var array 允许直接用类设置的属性名
     */
    protected $allowProperty = [];

    public static function __callStatic($method, $args)
    {
        $method = str_replace('_', '', $method);
        return container()->make(static::class)->$method(...$args);
    }

    protected function setAllowProperty($allowProperty)
    {
        $this->allowProperty = $allowProperty;
    }

    function __get($name)
    {
        // TODO: Implement __get() method.
        if (in_array($name, $this->allowProperty)) {
            return $this->$name;
        }
    }

    function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if (in_array($name, $this->allowProperty)) {
            return $this->$name = $value;
        }
    }
}