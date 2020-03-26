<?php

namespace app\Admin\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Model as MModel;
use app\Admin\Model\Config;
use dcr\Page;

class Model
{
    /**
     * @permission /文章列表
     * @return mixed
     * @throws \Exception
     */
    public function listView()
    {
        $assignData = array();
        $assignData['page_title'] = '列表';
        $modelName = current(container('request')->getParams());
        $assignData['model_name'] = $modelName;
        $where = array();
        $where[] = "ml_model_name='{$modelName}'";
        //开始搜索
        $title = get('title');
        if ($title) {
            $where[] = "ml_title like '%{$title}%'";
            $assignData['title'] = $title;
        }
        $categoryId = get('category_id');
        if ($categoryId) {
            $where[] = "ml_category_id={$categoryId}";
        }
        $dateStart = get('data_start');
        $dateEnd = get('data_end');
        if ($dateStart && $dateEnd) {
            $timeStart = strtotime($dateStart);
            $timeEnd = strtotime($dateStart);
            $where[] = "ml_add_time>{$timeStart} and ml_update_time<{$timeEnd}";
        }

        $join = array('type' => 'left', 'table' => 'zq_model_category', 'condition' => 'mc_id=ml_category_id');
        $model = new MModel();

        $assignData['category_select_html'] = $model->getCategorySelectHtml(
            $modelName,
            array('subEnabled' => 1, 'selectId'=> $categoryId, 'selectName' => 'category_id')
        );

        $pageInfo = $model->getList(array('where' => $where, 'join' => $join, 'col' => array('count(ml_id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $model->getList(array(
            'where' => $where,
            'col' => 'ml_id,ml_pic_path,ml_title,mc_name',
            'join' => $join,
            'order' => 'ml_id desc',
            'limit' => $pageNum,
            'offset' => ($page - 1) * $pageNum
        ));
        //dd($list);

        $assignData['page'] = $page;
        $assignData['num'] = $pageTotalNum;
        $assignData['model_list'] = $list;
        $assignData['pages'] = $pageHtml;
        $assignData['page_title'] = '用户列表';
        //$modelName = current(container('request')->getParams());
        //$assignData['config_list'] = $list;

        return Factory::renderPage('model/list', $assignData);
    }

    /**
     * @permission /文章列表/添加编辑
     * @return mixed
     * @throws \Exception
     */
    public function editView()
    {
        $assignData = array();
        $assignData['page_title'] = '添加/编辑';
        $model = new MModel();
        $config = new Config();
        $params = container('request')->getParams();
        $modelName = $params[0];
        $action = $params[1];
        $id = $params[2];
        $modelInfo = array();
        $configModelList = current($config->getConfigModelList($modelName));
        if ('edit' == $action && $id) {
            $modelInfo = $model->getInfo(
                $id,
                array('requestField' => 1, 'requestAddition' => 1, 'requestFieldDec' => 1)
            );
            //echo DB::getLastSql();
            $modelFieldList = $modelInfo['field'] ? $modelInfo['field'] : $configModelList;
        } else {
            //获取模型配置的附加字段
            $modelFieldList = $configModelList;
        }
        //dd($modelInfo);
        $assignData['category_select_html'] = $model->getCategorySelectHtml(
            $modelName,
            array(
                'subEnabled' => 1,
                'selectId' => $modelInfo['list']['ml_category_id'],
                'selectName' => 'list_category_id'
            )
        );
        //dd($modelFieldList);
        $assignData['field_list'] = $modelFieldList;
        $assignData['action'] = $action;
        $assignData['model_name'] = $modelName;
        $assignData['model_info'] = $modelInfo;
        //dd($modelInfo);
        return Factory::renderPage('model/edit', $assignData);
    }

    /**
     * @permission /文章列表/分类列表
     * @return mixed
     * @throws \Exception
     */
    public function categoryView()
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

    public function categoryEditView()
    {
        $assignData = array();
        $assignData['page_title'] = '分类编辑';
        $model = new MModel();
        $param = container('request')->getParams();
        $modelName = $param[0];
        $action = $param[1];
        $categoryId = $param[2] ? $param[2] : 1;
        $assignData['model_name'] = $modelName;
        $assignData['action'] = $action;
        $assignData['category_id'] = $categoryId;
        $categoryInfo = $model->getCategoryInfo($categoryId, array('col' => 'mc_name,mc_parent_id'));

        $assignData['category_name'] = $categoryInfo['mc_name'];
        //dd($assignData);
        $assignData['category_select_html'] = $model->getCategorySelectHtml(
            $modelName,
            array('selectId' => $categoryInfo['mc_parent_id'])
        );

        return Factory::renderPage('model/category-edit', $assignData);
    }

    public function categoryEditAjax()
    {
        $model = new MModel();
        $result = $model->categoryEdit(post());
        return Factory::renderJson($result);
    }

    public function deleteCategoryAjax()
    {
        $model = new MModel();
        $result = $model->deleteCategory(post('id'));
        return Factory::renderJson($result);
    }

    public function editAjax()
    {
        $model = new MModel();
        $result = $model->edit();
        return Factory::renderJson($result);
    }

    public function deleteAjax()
    {
        $model = new MModel();
        $id = post('id');
        $result = $model->delete($id);
        return Factory::renderJson($result);
    }
}
