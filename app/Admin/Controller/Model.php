<?php

namespace app\Admin\Controller;

use app\Admin\Model\Model as MModel;
use app\Admin\Model\Factory;
use app\Admin\Model\Config;
use app\Admin\Model\Common;
use dcr\Page;

class Model
{
    private $model_name = '模型';

    /**
     * @permission /文章列表
     * @return mixed
     * @throws \Exception
     */
    public function listView()
    {
        $assignData = array();
        $assignData['page_title'] = '列表';
        $assignData['page_model'] = $this->model_name;
        $modelName = current(container('request')->getParams());
        $assignData['model_name'] = $modelName;
        $where = array();
        $where[] = "ml_model_name='{$modelName}'";
        //开始搜索
        $title = get('title');
        if ($title) {
            $where[] = "title like '%{$title}%'";
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
            $where[] = "add_time>{$timeStart} and update_time<{$timeEnd}";
        }

        $join = array('type' => 'left', 'table' => 'model_category', 'condition' => 'model_category.id=ml_category_id');
        $model = new MModel();

        $assignData['category_select_html'] = $model->getCategorySelectHtml(
            $modelName,
            array('subEnabled' => 1, 'selectId' => $categoryId, 'selectName' => 'category_id')
        );

        $pageInfo = $model->getList(array('where' => $where, 'join' => $join, 'col' => array('count(model_list.id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 50;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $model->getList(array(
            'where' => $where,
            'col' => 'model_list.id,ml_pic_path,ml_title,name',
            'join' => $join,
            'order' => 'id desc',
            'limit' => $pageNum,
            'offset' => ($page - 1) * $pageNum
        ));
        //dd($list);

        $assignData['page'] = $page;
        $assignData['num'] = $pageTotalNum;
        $assignData['model_list'] = $list;
        $assignData['pages'] = $pageHtml;
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
        $assignData['page_model'] = $this->model_name;
        $model = new MModel();
        $config = new Config();
        $params = container('request')->getParams();
        $modelName = $params[0];
        $action = $params[1];
        $id = $params[2];
        $modelInfo = array();

        $fileValueList = array(); //field value值
        if ('edit' == $action && $id) {
            $modelInfo = $model->getInfo(
                $id,
                array('requestField' => 1, 'requestAddition' => 1, 'requestFieldDec' => 1)
            );
            //echo DB::getLastSql();
            $fileValueList = $modelInfo['field'];
            $fileValueList = array_column($fileValueList, 'mf_value', 'mf_keyword');
        } else {
        }

        //取出配置字段
        //得出cl_id
        $clsConfig = new Config();
        $list = $clsConfig->getConfigList(0, null, $modelName);
        $clId = $list[0]['id'];
        $modelFieldList = $clsConfig->getConfigListItemByListId($clId);
        foreach ($modelFieldList as $modelKey => $modelFieldInfo) {
            $modelFieldList[$modelKey]['data_type'] = $modelFieldInfo['data_type'];
            $modelFieldList[$modelKey]['db_field_name'] = $modelFieldInfo['db_field_name'];
            $modelFieldList[$modelKey]['default'] = $modelFieldInfo['default_str'];
        }
        $modelFieldList = Common::generalHtmlForItem($modelFieldList, $fileValueList, array(), array('input_name_pre'=>'field_'));

        //$configModelList = current($clsConfig->getConfigModelList($modelName));
        //dd($configModelList);

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
        $assignData['page_model'] = $this->model_name;
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
        $assignData['page_model'] = $this->model_name;
        $model = new MModel();
        $param = container('request')->getParams();
        $modelName = $param[0];
        $action = $param[1];
        $categoryId = $param[2] ? $param[2] : 1;
        $assignData['model_name'] = $modelName;
        $assignData['action'] = $action;
        $assignData['category_id'] = $categoryId;
        $categoryInfo = $model->getCategoryInfo($categoryId, array('col' => 'name,parent_id'));

        $assignData['category_name'] = $categoryInfo['name'];
        //dd($assignData);
        $assignData['category_select_html'] = $model->getCategorySelectHtml(
            $modelName,
            array('selectId' => $categoryInfo['parent_id'])
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
