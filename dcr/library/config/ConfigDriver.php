<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/31
 * Time: 0:33
 */

namespace dcr\Config;
/**
 * Interface ConfigDriver
 * @package dcr\Config
 */
interface ConfigDriver
{
    function parse($filename);
}