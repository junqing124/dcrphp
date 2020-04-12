<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Config as MConfig;
use app\Model\Define;

class Config
{
    /**
     * @permission /系统配置
     * @return mixed
     * @throws \Exception
     */
    public function configListView()
    {
        $assignData = array();
        $assignData['page_title'] = '配置项配置';

        $config = new MConfig();
        $list = $config->getConfigList();
        $assignData['config_list'] = $list;

        return Factory::renderPage('config/config-list', $assignData);
    }
    /**
     * @permission /系统配置
     * @return mixed
     * @throws \Exception
     */
    public function baseView()
    {
        $assignData = array();
        $assignData['page_title'] = '基础配置';
        $config = new MConfig();
        $list = $config->getConfigBaseList();
        if (!$list) {
            $list[0]['cb_name'] = 'site_name';
        }
        $assignData['config_list'] = $list;

        return Factory::renderPage('config/base', $assignData);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function templateView()
    {
        $assignData = array();
        $assignData['page_title'] = '模板配置';
        //get template list
        $config = new MConfig();
        $systemTemplateList = $config->getSystemTemplate();
        $assignData['system_template_list'] = $systemTemplateList;

        $configList = $config->getConfigBaseList('template');
        $configList = array_column($configList, 'cb_value', 'cb_name');
        $assignData['config_list'] = $configList;

        return Factory::renderPage('config/template', $assignData);
    }

    public function modelView()
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
        //dd($assignData);

        return Factory::renderPage('config/model', $assignData);
    }

    public function configBaseAjax()
    {
        $data = post();
        $type = $data['type'];
        //里面的type不是配置项 只是个类型 所以排除
        unset($data['type']);

        $config = new MConfig();
        $result = $config->configBase($data, $type);
        return Factory::renderJson($result);
    }

    public function configModelAjax()
    {
        $config = new MConfig();
        $result = $config->configModel(post());
        return Factory::renderJson($result);
    }

    public function configListEditAjax()
    {
        $config = new MConfig();
        $result = $config->configListEdit(post('config_list_name'), post('type'), post('id'));
        return Factory::renderJson($result);
    }

    public function configListDeleteAjax()
    {
        $config = new MConfig();
        $result = $config->configListDelete(post('id'));
        return Factory::renderJson($result);
    }
}
