<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Config as MConfig;
use app\Model\Common;
use dcr\Request;

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
    public function configListItemView(Request $request)
    {
        $params = $request->getParams();
        $listId = $params[0];

        $assignData = array();
        $assignData['page_title'] = '配置项子项配置';

        $config = new MConfig();
        $list = $config->getConfigListItemByListId($listId);

        $listInfo = $config->getConfigList($listId);
        $listInfo = current($listInfo);

        $assignData['config_list_item'] = $list;
        $assignData['list_id'] = $listId;
        $assignData['config_name'] = $listInfo['cl_name'];

        return Factory::renderPage('config/config-list-item', $assignData);
    }

    public function configListItemEditView(Request $request)
    {

        $params = $request->getParams();
        $type = $params[0];
        $listId = $params[1];
        $id = $params[2];
        $assignData = array();
        $assignData['page_title'] = '添加编辑配置项';
        $assignData['addition_id'] = $listId;
        $assignData['id'] = $id;
        $assignData['type'] = $type;
        $assignData['action'] = '/admin/config/config-list-item-ajax';

        $assignData['field_list'] = Common::getFieldTypeList();

        //得出数据来
        if('edit' == $type){
            $config = new MConfig();
            $itemInfo = $config->getConfigListItem($id);
            $itemInfo = current($itemInfo);
            $itemInfo['form_text'] = $itemInfo['cli_form_text'];
            $itemInfo['data_type'] = $itemInfo['cli_data_type'];
            $itemInfo['db_field_name'] = $itemInfo['cli_db_field_name'];
            $itemInfo['order'] = $itemInfo['cli_order'];
            $itemInfo['default'] = $itemInfo['cli_default'];
            $assignData['item_info'] = $itemInfo;
        }

        return Factory::renderPage('common/filed-html-item', $assignData);
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
        $assignData['define_list'] = Common::getModelCommon();

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

    public function configListItemAjax()
    {
        $data = post();
        $type = $data['type'];
        //里面的type不是配置项 只是个类型 所以排除
        unset($data['type']);

        $config = new MConfig();
        $result = $config->configListItem($data, $type);
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
