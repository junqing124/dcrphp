<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Model as MModel;
use app\Admin\Model\Config;
use dcr\Page;

class Model
{
    function listView()
    {
        $assignData = array();
        $assignData['page_title'] = '列表';
        $modelName = current(container('request')->getParams());
        $assignData['model_name'] = $modelName;
        $where  = array();
        $where[] = "ml_model_name='{$modelName}'";


        $join = array('type'=> 'left', 'table'=>'zq_model_category', 'condition'=>'mc_id=ml_category_id');
        $model = new MModel();

        $assignData['category_select_html'] = $model->getCategorySelectHtml($modelName,
            array('subEnabled' => 1, 'selectName' => 'category_id'));

        $pageInfo = $model->getList(array('where' => $where, 'join'=> $join, 'col' => array('count(ml_id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $model->getList(array('where' => $where, 'join'=> $join, 'order' => 'ml_id desc', 'limit' => $pageNum, 'offset' => ($page - 1) * $pageNum));

        $assignData['page'] = $page;
        $assignData['num'] = $pageTotalNum;
        $assignData['model_list'] = $list;
        $assignData['pages'] = $pageHtml;
        $assignData['page_title'] = '用户列表';
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
        $assignData['category_select_html'] = $model->getCategorySelectHtml($modelName,
            array('subEnabled' => 1, 'selectName' => 'list_category_id'));
        //获取模型配置的附加字段
        $modelFieldList = current($config->getConfigModelList($modelName));
        //dd($modelFieldList);
        $assignData['field_list'] = $modelFieldList;
        $assignData['action'] = 'add';
        $assignData['model_name'] = $modelName;
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
        $assignData['category_select_html'] = $model->getCategorySelectHtml($modelName,
            array('selectId' => $categoryInfo['mc_parent_id']));

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

    function editAjax()
    {
        $model = new MModel();
        $result = $model->edit();
        return Factory::renderJson($result);
    }

}