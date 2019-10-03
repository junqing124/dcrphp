<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/10
 * Time: 18:27
 */

namespace dcr\Route;

use dcr\DcrBase;

class RuleItem extends DcrBase
{
    function __construct()
    {
        //允许自定的属性列表
        parent::setAllowProperty(['model', 'controller', 'action', 'params']);
    }

}