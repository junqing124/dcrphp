<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/20
 * Time: 23:15
 */

namespace dcr;

/**
 * Class Response
 * @package dcr
 */
class Response extends DcrBase
{
    /**
     * 输出的内容
     * @var
     */
    private $data;

    /**
     * Response constructor.
     * @param $data 输出的内容
     */
    public function __construct($data)
    {
        $this->allowProperty = array('data');
        $this->data = $data;
    }

    /**
     * 输出页面
     */
    public function send()
    {
        echo $this->data;
    }

    /**
     * 页面跳转
     * @param $url 跳转的url
     */
    public function redirect($url)
    {
        header("Location:{$url}");
    }
}
