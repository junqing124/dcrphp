<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Model\Plugins;

class Tools
{
    /**
     * @permission /系统工具
     * @return mixed
     * @throws \Exception
     */
    public function tableGeneralView()
    {

        $assignData = array();
        $assignData['page_title'] = '生成表结构';

        return Factory::renderPage('tools/table-general', $assignData);
    }

    public function pluginsView()
    {

        $assignData = array();
        $assignData['page_title'] = '插件中心';

        //得出本地插件列表
        $clsPlugins = new Plugins();
        $localPluginsList = $clsPlugins->getLocalPluginsList();
        $assignData['plugin_list'] = $localPluginsList;

        return Factory::renderPage('tools/plugins', $assignData);
    }

    public function pluginsInstalledView()
    {

        $assignData = array();
        $assignData['page_title'] = '已安装列表';

        $clsPlugins = new Plugins();
        $list = $clsPlugins->getInstalledList();
        $assignData['plugin_list'] = $list;

        return Factory::renderPage('tools/plugins-installed', $assignData);
    }

    public function pluginInstallAjax()
    {
        $name = post('name');
        $source = post('source');

        $clsPlugins = new Plugins();
        $result = $clsPlugins->install($name, $source);
        return Factory::renderJson($result);
    }
}
