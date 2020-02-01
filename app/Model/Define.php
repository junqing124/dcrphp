<?php

namespace app\Model;

class Define
{
    static function getModelDefine()
    {
        return array(
                'news' => array('key'=>1, 'dec'=>'新闻中心', 'name'=> 'news', ),
                'product' =>  array('key'=>2, 'dec'=>'产品中心', 'name'=> 'product', ),
                'info' =>  array('key'=>3, 'dec'=>'资料中心', 'name'=> 'info', ),
            );

    }
}