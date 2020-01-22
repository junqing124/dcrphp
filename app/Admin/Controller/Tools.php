<?php


namespace app\Admin\Controller;


use app\Admin\Model\Factory;

class Tools
{
    function tableGeneralView()
    {

        $assignData = array();
        $assignData['page_title'] = '生成表结构';

        return Factory::renderPage('tools/table-general', $assignData);
    }
}