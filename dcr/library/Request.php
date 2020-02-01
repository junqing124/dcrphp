<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/29
 * Time: 0:04
 */

namespace dcr;

use dcr\Config;


class Request extends DcrBase
{
    /**
     * @var POST数据
     */
    private $post;

    /**
     * @var GET数据
     */
    private $get;

    /**
     * @var null 实例
     */
    private static $instance = null;

    /**
     * @var string pathInfo
     */
    protected $pathInfo;

    /**
     * @var 参数列表
     */
    protected $params;
    /**
     * @var string pathinfo（不含后缀）
     */
    protected $path;

    /**
     * 禁止实例化
     */
    private function __construct()
    {
        //允许自定的属性列表
        parent::setAllowProperty(['model', 'controller', 'action', 'params']);
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
     * 获取当前请求URL的pathinfo信息（含URL后缀）
     * @access public
     * @return string
     */
    public function getPathInfo()
    {
        if (is_null($this->pathInfo)) {
            $urlType = 'REDIRECT_URL';
            $_SERVER['PATH_INFO'] = (0 === strpos($_SERVER[$urlType], $_SERVER['SCRIPT_NAME'])) ?
                substr($_SERVER[$urlType], strlen($_SERVER['SCRIPT_NAME'])) : $_SERVER[$urlType];
            $this->pathInfo = empty($_SERVER['PATH_INFO']) ? '/' : ltrim($_SERVER['PATH_INFO'], '/');
        }
        return $this->pathInfo;
    }

    /**
     * 获取当前请求URL的pathinfo信息(不含URL后缀)
     * @access public
     * @return string
     */
    public function getPath()
    {
        if (is_null($this->path)) {
            $pathInfo = $this->getPathInfo();
            $this->path = preg_replace('/\.' . $this->ext() . '$/i', '', $pathInfo);
        }
        return $this->path;
    }

    /**
     * 当前URL的访问后缀
     * @access public
     * @return string
     */
    public function ext()
    {
        return pathinfo($this->getPathInfo(), PATHINFO_EXTENSION);
    }

    /**
     * 设置路径里的参数
     * @param $params
     */
    public function setParams($params)
    {
        $params = array_merge($params); //重置数组下标
        $this->params = $params;
    }

    /**
     * 用来获取比如/admin/config/config/test里的test
     * @return 参数列表
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 获取post内容
     * @param string $name
     * @param string $default
     * @return string
     */
    public function post($name = '', $default = '')
    {
        return $this->input('post', $name, $default);
    }

    /**
     * 获取get内容
     * @param string $name
     * @param string $default
     * @return string
     */
    public function get($name = '', $default = '')
    {
        return $this->input('get', $name, $default);
    }

    public function input($type, $name = '', $default = '')
    {
        if (!$this->$type) {
            $data = array();
            switch ($type) {
                case 'get':
                    $data = $_GET;
                    break;
                case 'post':
                    $data = $_POST;
                    break;
            }
            $this->$type = $data;
        }

        if ($name) {
            $info = $this->$type[$name] ? $this->$type[$name] : $default;
        }else
        {
            $info = $this->$type;
        }
        return $info;
    }
}