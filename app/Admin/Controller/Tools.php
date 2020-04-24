<?php

namespace app\Admin\Controller;

use app\Admin\Model\Common;
use app\Admin\Model\Factory;
use app\Admin\Model\Plugins;
use dcr\Page;
use dcr\Request;
use dcr\View;
use dcr\Db;
use app\Admin\Model\Tools as MTools;

class Tools
{

    private $model_name = '工具';

    public function pluginsView()
    {

        $assignData = array();
        $assignData['page_title'] = '插件中心';
        $assignData['page_model'] = $this->model_name;

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
        $assignData['page_model'] = $this->model_name;

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
     * 具体请参看帮助中心的[插件开发]
     */
    public function pluginsAjax(Request $request)
    {
        $params = $request->getParams();
        $functionName = current($params) ? current($params) : post('function_name');
        $functionName = $functionName ? $functionName : get('function_name');
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
    public function pluginsIndexView(Request $request, View $view)
    {
        $params = $request->getParams();
        $pluginName = current($params) ? current($params) : 'TableGeneral'; //默认一个是为了自动化测试

        $clsPlugins = new Plugins();
        $pluginDir = $clsPlugins->getPluginDir($pluginName);
        $config = $clsPlugins->getConfig($pluginName);
        $viewDir = $pluginDir . DS . 'View';
        $indexView = 'index';
        if (!file_exists($viewDir . DS . $indexView . '.html')) {
            throw new \Exception('没有找到这个view:' . $indexView);
        }
        $assignData = array();
        $assignData['page_title'] = $config['description'];
        $assignData['page_model'] = $this->model_name;
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

    public function tableEditEditAjax()
    {
        $data = post();
        $tableName = $data['table_role_name'];
        //用通用接口去处理
        $clsTools = new MTools();
        $configPath = $clsTools->getTableEditConfigPath($tableName);
        $config = include_once $configPath;
        if ('delete' == $data['type']) {

            $result = Common::CUDDbInfo(
                $tableName,
                $config['table_pre'],
                array(),
                $data['type'],
                $option = array('id' => $data['id'], 'check' => array())
            );
        } else {
            //dd($config);
            //处理检测程序
            $check = array();
            $listCol = array();
            if ('add' == $data['type']) {
                foreach ($config['col'] as $configKey => $configValue) {
                    if ($configValue['is_insert_required']) {
                        $check[$configKey] = array('type' => 'required');
                    }
                    if ($configValue['is_insert']) {
                        $listCol[] = $configValue;
                    }
                }
            }
            if ('edit' == $data['type']) {
                foreach ($config['col'] as $configKey => $configValue) {
                    if ($configValue['is_update_required']) {
                        $check[$configKey] = array('type' => 'required');
                    }
                    if ($configValue['is_update']) {
                        $listCol[] = $configValue;
                    }
                }
            }

            //要更新的数据
            $dbInfo = array();
            foreach ($listCol as $colInfo) {
                $dbInfo[$colInfo['db_field_name']] = $data[$colInfo['db_field_name']];
            }

            $result = Common::CUDDbInfo(
                $config['table_name'],
                $config['table_pre'],
                $dbInfo,
                $data['type'],
                $option = array('id' => $data['id'], 'check' => $check)
            );
        }

        return Factory::renderJson($result);
    }

    public function tableEditEditView(Request $request)
    {

        $params = $request->getParams();
        $type = $params[0];
        $tableName = $params[1];
        $id = $params[2];
        $clsTools = new MTools();
        $configPath = $clsTools->getTableEditConfigPath($tableName);
        $config = include_once $configPath;

        $listCol = array();
        $checkKey = 'add' == $type ? 'is_insert' : 'is_update';

        //得出insert或update的字段来
        foreach ($config['col'] as $configKey => $configValue) {
            if ($configValue[$checkKey]) {
                $listCol[$configKey] = $configValue;
            }
        }
        //开始格式化成标准格式
        //如果是编辑 则得出值
        $info = array();
        if ('edit' == $type) {
            $info = Db::select(
                array(
                    'table' => $config['table_name'],
                    'where' => "{$config['index_id']}={$id}",
                    'limit' => 1,
                )
            );
            $info = current($info);
        }
        $fieldList = Common::generalHtmlForItem($listCol, $info);
        //dd($fieldList);

        $assignData = array();
        $assignData['page_title'] = $config['page_title'];
        $assignData['page_model'] = $config['page_model'];
        $assignData['type'] = $type;
        $assignData['table_role_name'] = $tableName;
        $assignData['field_list'] = $fieldList;
        $assignData['id'] = $id;
        $assignData['index_id'] = $config['index_id'];

        return Factory::renderPage('tools/table-edit-edit', $assignData);

    }

    public function tableEditListView(Request $request)
    {

        $params = $request->getParams();
        $tableName = current($params);
        $clsTools = new MTools();
        $configPath = $clsTools->getTableEditConfigPath($tableName);
        $config = include_once $configPath;
        $assignData = array();
        $assignData['page_title'] = $config['page_title'];
        $assignData['page_model'] = $config['page_model'];

        $whereArr = array();
        if ($config['list_where']) {
            $whereArr[] = $config['list_where'];
        }
        $searchData = get();
        //dd($config);
        foreach( $searchData as $searchKey=> $searchValue ){
            $searchType = $config['col'][$searchKey]['search_type'];
            switch ($searchType){
                case 'like':
                    $whereArr[] = "{$searchKey} like '%{$searchValue}%'";
                    break;
                case 'like_left':
                    $whereArr[] = "{$searchKey} like '{$searchValue}%'";
                    break;
                case 'like_right':
                    $whereArr[] = "{$searchKey} like '%{$searchValue}'";
                    break;
                case 'equal':
                    $whereArr[] = "{$searchKey}='{$searchValue}'";
                    break;
            }
        }

        //获取列表要显示的列
        $listCol = array();

        $searchCol = array();
        foreach ($config['col'] as $configKey => $configValue) {
            if ($configValue['is_show_list']) {
                $listCol[$configKey] = $configValue;
            }
            if ($configValue['is_search']) {
                $searchCol[$configKey] = $configValue;
            }
        }
        if($searchCol){
            $searchCol = Common::generalHtmlForItem($searchCol,$searchData);
        }

        //总数量
        $pageInfo = Db::select(
            array(
                'table' => $config['table_name'],
                'where' => $whereArr,
                'col' => array('count(' . $config['index_id'] . ') as num'),
            )
        );

        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = Db::select(
            array(
                'table' => $config['table_name'],
                'order' => $config['list_order'],
                'where' => $whereArr,
                'col' => implode(',', array_keys($listCol)) . ',' . $config['index_id'] . ' as id',
                'offset' => ($page - 1) * $pageNum,
                'limit' => $pageNum,
            )
        );

        $assignData['list'] = $list;
        $assignData['list_col'] = $listCol;
        $assignData['search_col'] = $searchCol;
        $assignData['page'] = $page;
        $assignData['user_num'] = $pageTotalNum;
        $assignData['pages'] = $pageHtml;
        $assignData['config'] = $config;

        return Factory::renderPage('tools/table-edit-list', $assignData);
    }
}
