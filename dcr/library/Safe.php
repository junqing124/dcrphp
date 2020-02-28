<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/20
 * Time: 21:42
 */

namespace dcr;

/**
 * Class Safe 安全类
 * @package dcr
 */
class Safe extends DcrBase
{
    /**
     * 加密字符串
     * @param $password
     * @return string
     */
    function encrypt($password)
    {
        return crypt(md5($password), 'dcr');
    }
}