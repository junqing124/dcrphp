<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Config as MConfig;
use app\Admin\Model\Common;
use dcr\Request;

class Config
{
    private $model_name = '配置';

    /**
     * @return mixed
     * @throws \Exception
     */
    public function configListView()
    {
        $assignData = array();
        $assignData['page_title'] = '配置项配置';
        $assignData['page_model'] = $this->model_name;
        $params = container('request')->getParams();
        $clType = $params[0] ? $params[0] : 'config';

        $config = new MConfig();
        $list = $config->getConfigList(0, $clType);
        $assignData['config_list'] = $list;
        $assignData['model'] = $clType;

        return Factory::renderPage('config/config-list', $assignData);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function configListItemView(Request $request)
    {
        $params = $request->getParams();
        $listId = $params[0];

        $assignData = array();
        $assignData['page_title'] = '配置项子项配置';
        $assignData['page_model'] = $this->model_name;

        $config = new MConfig();
        $list = $config->getConfigListItemByListId($listId);

        $listInfo = $config->getConfigList($listId);
        $listInfo = current($listInfo);

        $assignData['config_list_item'] = $list;
        $assignData['list_id'] = $listId;
        $assignData['config_name'] = $listInfo['name'];

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
        $assignData['page_model'] = $this->model_name;
        $assignData['addition_id'] = $listId;
        $assignData['id'] = $id;
        $assignData['type'] = $type;
        $assignData['action'] = '/admin/config/config-list-item-ajax';

        $assignData['field_list'] = Common::getFieldTypeList();

        //得出数据来
        if ('edit' == $type) {
            $config = new MConfig();
            $itemInfo = $config->getConfigListItem($id);
            $itemInfo = current($itemInfo);
            $assignData['item_info'] = $itemInfo;
        }

        return Factory::renderPage('common/filed-html-item', $assignData);
    }

    /**
     * @permission /系统配置
     * @return mixed
     * @throws \Exception
     */
    public function configView(Request $request)
    {
        $assignData = array();
        $assignData['page_title'] = '基础配置';
        $assignData['page_model'] = $this->model_name;

        $params = $request->getParams();
        $clsConfig = new MConfig();

        //得出系统变量要用的值
        $systemTemplateList = $clsConfig->getSystemTemplate();
        $systemTemplateStr = implode(',', $systemTemplateList); //配置项是:var.systemTemplateStr

        //得出基础配置项
        $configListId = current($params);
        $configItemList = $clsConfig->getConfigListItemByListId($configListId);
        //得出配置值
        $configValueList = $clsConfig->getConfigValueList($configListId);
        $configValueList = array_column($configValueList, 'value', 'db_field_name');
        //格式化
        foreach ($configItemList as $key => $configItemInfo) {
            $configItemList[$key]['data_type'] = $configItemInfo['data_type'];
            $configItemList[$key]['db_field_name'] = $configItemInfo['db_field_name'];
            $configItemList[$key]['default'] = $configItemInfo['default'];
        }
        $configItemList = Common::generalHtmlForItem($configItemList, $configValueList, get_defined_vars());

        $assignData['config_item_list'] = $configItemList;
        $assignData['config_value_list'] = $configValueList;
        $assignData['list_id'] = $configListId;

        return Factory::renderPage('config/config', $assignData);
    }

    /**
     * 从1.0.3开始作废
     * @return mixed
     * @throws \Exception
     */
    public function modelViewAbandon()
    {

        $assignData = array();
        $assignData['page_title'] = '模型配置';
        $assignData['page_model'] = $this->model_name;
        $assignData['define_list'] = Common::getModelDefine();

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

    public function configAjax()
    {
        $data = post();
        $list_id = $data['list_id'];
        //里面的type不是配置项 只是个类型 所以排除
        unset($data['list_id']);

        $config = new MConfig();
        $result = $config->config($data, $list_id);
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

    /**
     * 从1.0.3开始作废
     * @return mixed
     */
    public function configModelAjaxAbandon()
    {
        $config = new MConfig();
        $result = $config->configModel(post());
        return Factory::renderJson($result);
    }

    public function configListEditAjax()
    {
        $config = new MConfig();
        $result = $config->configListEdit(post('config_list_name'), post('type'), post('id'), post('model'), post('config_list_key'));
        return Factory::renderJson($result);
    }

    public function configListDeleteAjax()
    {
        $config = new MConfig();
        $result = $config->configListDelete(post('id'));
        return Factory::renderJson($result);
    }
}
