<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Model as MModel;
use app\Admin\Model\Config;

class Model
{
    function listView()
    {
        $assignData = array();
        $assignData['page_title'] = '列表';
        $modelName = current(container('request')->getParams());
        $assignData['model_name'] = $modelName;
        //$modelName = current(container('request')->getParams());
        //$assignData['config_list'] = $list;

        return Factory::renderPage('model/list', $assignData);
    }

    function editView()
    {
        $assignData = array();
        $assignData['page_title'] = '添加/编辑';
        $model = new MModel();
        $config = new Config();
        $modelName = current(container('request')->getParams());
        $assignData['category_select_html'] = $model->getCategorySelectHtml($modelName, array( 'subEnabled'=> 1, 'selectName'=> 'list_category_id' ));
        //获取模型配置的附加字段
        $modelFieldList = current($config->getConfigModelList($modelName));
        //dd($modelFieldList);
        $assignData['field_list'] = $modelFieldList;
        return Factory::renderPage('model/edit', $assignData);
    }

    function categoryView()
    {
        $assignData = array();
        $assignData['page_title'] = '分类列表';
        $modelName = current(container('request')->getParams());
        $assignData['model_name'] = $modelName;
        $model = new MModel();
        $assignData['category_list'] = $model->getCategoryList($modelName);
        $assignData['category_html'] = $model->getCategoryTrHtml($modelName);
        //dd($assignData);

        return Factory::renderPage('model/category', $assignData);
    }

    function categoryEditView()
    {
        $assignData = array();
        $assignData['page_title'] = '分类编辑';
        $model = new MModel();
        $param = container('request')->getParams();
        $modelName = $param[0];
        $action = $param[1];
        $categoryId = $param[2];
        $assignData['model_name'] = $modelName;
        $assignData['action'] = $action;
        $assignData['category_id'] = $categoryId;
        $categoryInfo = $model->getCategoryInfo($categoryId, array('col' => 'mc_name,mc_parent_id'));

        $assignData['category_name'] = $categoryInfo['mc_name'];
        //dd($assignData);
        $assignData['category_select_html'] = $model->getCategorySelectHtml($modelName, array('selectId'=> $categoryInfo['mc_parent_id']));

        return Factory::renderPage('model/category-edit', $assignData);

    }

    function categoryEditAjax()
    {
        $model = new MModel();
        $result = $model->categoryEdit(post());
        return Factory::renderJson($result);
    }

    function deleteCategoryAjax()
    {
        $model = new MModel();
        $result = $model->deleteCategory(post('id'));
        return Factory::renderJson($result);
    }

}