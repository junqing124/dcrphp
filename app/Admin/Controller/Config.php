<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Config as MConfig;
use app\Model\Define;

class Config
{
    function configBaseView()
    {
        $assignData = array();
        $assignData['page_title'] = '基础配置';
        $config = new MConfig();
        $list = $config->getConfigBaseList();
        if (!$list) {
            $list[0]['cb_name'] = 'site_name';
        }
        $assignData['config_list'] = $list;

        return Factory::renderPage('config/config-base', $assignData);
    }

    function configModelView()
    {

        $assignData = array();
        $assignData['page_title'] = '模型配置';
        $assignData['define_list'] = Define::getModelDefine();

        $config = new MConfig();
        $modelList = $config->getConfigModelList();
        //补空
        foreach ($assignData['define_list'] as $defineKey => $defineInfo) {
            if (!$modelList[$defineKey]) {
                $modelList[$defineKey] = array(array(1));
            }
        }
        $assignData['model_list'] = $modelList;

        return Factory::renderPage('config/config-model', $assignData);
    }

    function configBaseAjax()
    {
        $info = array(
            'site_name' => post('site_name'),
        );

        $config = new MConfig();
        $result = $config->configBase($info);
        return Factory::renderJson($result);
    }

    function configModelAjax()
    {
        $config = new MConfig();
        $result = $config->configModel(post());
        return Factory::renderJson($result);
    }

}