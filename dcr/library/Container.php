<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

namespace dcr;

use ReflectionClass;
use ReflectionParameter;
use ReflectionException;

class Container
{
    /**
     * @var null 实例
     */
    private static $instance = null;

    /**
     * @var array 绑定的列表
     */
    private $bindList = [];
    /**
     * @var array 用于存窗口的实例列表
     */
    private $instanceList = [];

    /**
     * 这个是为了在启动的时候，自动加载某类
     * @var string[]
     */
    private $defaultBindList = [
        'config' => \dcr\Config::class,
        'request' => \dcr\Request::class,
        'rule' => \dcr\route\Rule::class,
        'rule_item' => \dcr\route\RuleItem::class,
        'route' => \dcr\Route::class,
        'view' => \dcr\View::class,
        'response' => \dcr\Response::class,
    ];

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
     * 获取实例
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 自动绑定
     */
    public function autoBind()
    {
        $alias = container()->make(\dcr\Config::class)->get('app.alias');
        foreach ($alias as $key => $bindInfo) {
            $this->bind($key, $bindInfo);
        }
    }

    /**
     * @param $abstract 绑定名称
     * @param null $concrete 名称或实例
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindList[$abstract] = $concrete;
    }

    /**
     * 获取绑定的实例类名
     *
     * @param string $abstract
     * @return mixed   $concrete
     */
    protected function getConcrete($abstract)
    {
        if (isset($this->bindList[$abstract])) {
            return $this->bindList[$abstract];
        }
        if (isset($this->defaultBindList[$abstract])) {
            return $this->defaultBindList[$abstract];
        }

        return $abstract;
    }

    /**
     * 绑定类实例
     * @param $abstract 类名
     * @param $instance 实例
     * @return object
     */
    public function instance($abstract, $instance)
    {
        $concrete = $this->getConcrete($abstract);
        $this->instanceList[$concrete] = $instance;
        return $instance;
    }

    /**
     * @param $abstract 类名或别名
     * @return mixed|object
     * @throws ReflectionException
     */
    public function make($abstract)
    {
        //先拿从bind里绑定来的 比如绑定config到dcr\Config 则行拿出来Config
        $concrete = $this->getConcrete($abstract);

        if (isset($this->instanceList[$concrete])) {
            return $this->instanceList[$concrete];
        }

        //开始实例化
        $reflector = new ReflectionClass($concrete);

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            $instance = new $concrete;
            $this->instance($concrete, $instance);
            return $instance;
        }
        //构造函数是私有的
        if ($constructor->isPrivate()) {
            $instance = $concrete::getInstance();
            $this->instance($concrete, $instance);
            return $instance;
        }
        //解决构造参数里的实例
        $dependenciesList = $constructor->getParameters();

        $dependencies = $this->resolveConstructor($dependenciesList);

        $instance = $reflector->newInstanceArgs($dependencies);

        $this->instance($concrete, $instance);
        return $instance;
    }

    /**
     * 解决构造函数
     * @param $dependencies 参数列表
     * @return array
     */
    public function resolveConstructor($dependencies)
    {
        if (empty($dependencies)) {
            return [];
        }
        foreach ($dependencies as $dependency) {
            $results[] = is_null($dependency->getClass())
                ? $this->resolvePrimitive($dependency)
                : $this->resolveClass($dependency);
        }
        return $results;
    }

    /**
     * 解决构造函数里的非类数值
     * @param $parameter 参数列表
     * @return object
     */
    public function resolvePrimitive(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        } else {
            return [];
        }
    }

    /**
     * 解决构造函数里的类实例化
     * @param $parameter 参数列表
     */
    public function resolveClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
