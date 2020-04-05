<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Model\Plugins;
use dcr\Request;
use dcr\View;

class Tools
{

    public function pluginsView()
    {

        $assignData = array();
        $assignData['page_title'] = '插件中心';

        //得出本地插件列表
        $clsPlugins = new Plugins();
        $localPluginsList = $clsPlugins->getLocalPluginsList();
        $assignData['plugin_list'] = $localPluginsList;

        $listInstalled = $clsPlugins->getInstalledList();
        $listInstalled = array_column($listInstalled, 'p_name');
        $assignData['plugin_installed_list'] = $listInstalled;

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

    /**
     * 插件的核心方法:通过不同的参数调用到插件的function
     */
    public function pluginsAjax(Request $request)
    {
        $params = $request->getParams();
        $functionName = current($params);
        $pluginName = post('plugin_name') ? post('plugin_name') : get('plugin_name');

        $clsPlugins = new Plugins();
        $pluginControllerName = $clsPlugins->getControllerClass($pluginName);
        if (!class_exists($pluginControllerName)) {
            throw new \Exception($pluginControllerName . ':Crontroller不存在');
        }

        $pluginClass = new $pluginControllerName;
        if (!method_exists($pluginClass, $functionName)) {
            throw new \Exception($functionName . ':function不存在');
        }

        $result = $pluginClass->$functionName(array_merge(post(), get()));
        return Factory::renderJson($result);
    }

    /**
     * 插件核心入口，进入插件的首页，就是调用这个
     * @param Request $request
     * @param View $view
     * @return mixed
     * @throws \Exception
     */
    public function enterPluginsView(Request $request, View $view)
    {
        $params = $request->getParams();
        $pluginName = current($params) ? current($params) : 'TableGeneral'; //默认一个是为了自动化测试

        $pluginDir = ROOT_APP . DS . 'Plugins' . DS . $pluginName;
        $clsPlugins = new Plugins();
        $config = $clsPlugins->getConfig($pluginName);
        $viewDir = $pluginDir . DS . 'View';
        $indexView = 'index';
        if (!file_exists($viewDir . DS . $indexView . '.html')) {
            throw new \Exception('没有找到这个view:' . $indexView);
        }
        $assignData = array();
        $assignData['page_title'] = $config['description'];
        //调用插件的index
        $pluginControllerName = $clsPlugins->getControllerClass($pluginName);
        if (class_exists($pluginControllerName)) {
            $pluginClass = new $pluginControllerName;
            if (method_exists($pluginClass, 'index')) {
                $pluginClass->index($view);
            }
        }
        //$pluginIndexController = new ;
        return Factory::renderPage($indexView, $assignData, $viewDir);
    }
}
