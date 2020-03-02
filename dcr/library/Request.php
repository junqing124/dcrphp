<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/29
 * Time: 0:04
 */

namespace dcr;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

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
            //从REQUEST_URI取最保险
            $info = parse_url($_SERVER['REQUEST_URI']);
            $this->pathInfo = $info['path'] ? ltrim($info['path'], '/') : '/';
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
        } else {
            $info = $this->$type;
        }
        return $info;
    }

    /**
     * 上传文件
     * @param $inputName
     * @param $targetDir
     * @param array $ruler 规则，是一个数组，配置如下 newFileName=> 新文件名, maxSize=>'5M'(use "B", "K", M", or "G") allowFile=> array('image/png', 'image/gif')
     *  allowFile配置可见:http://www.iana.org/assignments/media-types/media-types.xhtml
     * @return array
     */
    function upload($inputName, $targetDir, $ruler = array())
    {
        $filesystem = new Filesystem();
        try {
            $filesystem->mkdir($targetDir);
        } catch (IOExceptionInterface $exception) {
            $result = array();
            $result['ack'] = 0;
            $result['msg'] = "自动创建目录失败: " . $exception->getPath();
            return $result;
        }

        $storage = new \Upload\Storage\FileSystem($targetDir);
        $file = new \Upload\File($inputName, $storage);

        $newFileName = $ruler['newFileName'] ? $ruler['newFileName'] : time() . uniqid();
        $file->setName($newFileName);

        //默认的属性和大小
        if (!isset($ruler['allowFile'])) {
            $ruler['allowFile'] = '*.*';
        }
        if (!isset($ruler['maxSize'])) {
            $ruler['maxSize'] = '2M';
        }

        $fileData = array(
            'name' => $file->getNameWithExtension(),
            'extension' => $file->getExtension(),
            'mime' => $file->getMimetype(),
            'size' => $file->getSize(),
            'md5' => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );
        /*dd($fileData);
        dd($ruler);*/
        $file->addValidations(array(
            new \Upload\Validation\Mimetype($ruler['allowFile']),
            new \Upload\Validation\Size($ruler['maxSize'])
        ));

        $result = array();
        try {
            // Success!
            $file->upload();
            $result['ack'] = 1;
            $result['msg'] = $fileData;
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
            $result['ack'] = 0;
            $result['msg'] = $errors . "->当前类型是:{$fileData['mime']},大小是:{$fileData['size']}";
        }
        return $result;
    }

    public function isAjax()
    {
        return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && (strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest");
    }

}