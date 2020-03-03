<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/31
 * Time: 0:35
 */

namespace dcr\config\driver;

use dcr\config\ConfigDriver;

class Php implements ConfigDriver
{
    function parse($filename)
    {
        return include $filename;
    }
}
