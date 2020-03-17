<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;

class Tools
{
    /**
     * @permission /系统工具/生成表结构
     * @return mixed
     * @throws \Exception
     */
    public function tableGeneralView()
    {

        $assignData = array();
        $assignData['page_title'] = '生成表结构';

        return Factory::renderPage('tools/table-general', $assignData);
    }
}
