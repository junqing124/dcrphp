<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/20
 * Time: 13:42
 */

namespace app\Admin\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use dcr\Session;
class Captcha
{
    /**
     * 输出验证码
     */
    function output()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        Session::_set('captcha',$builder->getPhrase());
        header('Content-type: image/jpeg');
        $builder->output();
    }
}