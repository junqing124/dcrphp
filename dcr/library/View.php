<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/4
 * Time: 0:56
 */

namespace dcr;

use twig\twig;

/**
 * Class View
 * @package dcr
 */
class View extends DcrBase
{
    /**
     * @var view目录路径
     */
    private $viewDirectoryPath;
    /**
     * @var \Twig_Environment
     */
    protected $twig;
    /**
     * @var array 数据
     */
    protected $data = array();

    public function setViewDirectoryPath($path)
    {
        $this->viewDirectoryPath = $path;
    }

    /**
     * 获取view目录路径
     */
    public function getViewDirectoryPath()
    {
        if (!$this->viewDirectoryPath) {
            $this->viewDirectoryPath = ROOT_APP . DS . 'Index' . DS . 'View';
        }
        return $this->viewDirectoryPath;
    }

    public function __construct()
    {
        $path = $this->getViewDirectoryPath();
        $loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($loader, array(
            'debug' => false // 开启调试模式
        ));

        if (config('app.view_cache')) {
            $this->twig->setCache(ROOT_APP . DS . 'Cache');
        }
        $this->allowProperty = array('outFormat', 'data');
    }

    /**
     * 设置模板数据
     * 2中设置方法
     * 1）key value方式：assign('key', 'value')
     * 2）数组方式：assign(array('key' => 'value'))
     */
    public function assign($var, $value = null)
    {
        if (is_array($var)) {
            $this->data = array_merge($this->data, $var);
        } else {
            $this->data[$var] = $value;
        }
    }

    /**
     * 渲染模板 html和json都支持 如果想输出json 请view->outFormat='json' 也可以在用view之前配置变量outFormat outFormat是优先级最高
     * @param $template //如果输出的为json模式 则这个值可为空
     * @return string
     * @throws \Throwable
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render($template = '')
    {
        $request = container('request');
        $outFormatFinal = $request->isAjax() ? 'ajax' : 'html';
        /*dd($this->outFormat);
        exit;*/
        if ('html' == $outFormatFinal) {
            $templatePath = $this->viewDirectoryPath;
            $this->twig->setLoader(new \Twig_Loader_Filesystem($templatePath));
            $template = $this->twig->loadTemplate($template . '.html');
            return $template->render($this->data);
        } else {
            $data = $this->data;
            //如果是数组，则转为字符串输出
            if (is_array($data['msg'])) {
                $data['msg'] = implode(',', $data['msg']);
            }
            return json_encode($data);
        }
    }
}
