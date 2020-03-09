<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/13
 * Time: 0:41
 */

namespace app\Index\Controller;

use app\Model\Define;
use dcr\Db;
use dcr\Page;
use dcr\Request;
use app\Admin\Model\Model;
use app\Admin\Model\Config;

/**
 * Class Index
 * @package app\Index\Controller
 */
class Index
{

    public function viewCommon($view, $title, $position)
    {
        if (empty($title) || empty($position)) {
            throw new \Exception('请设置标题');
        }
        if (empty($position)) {
            throw new \Exception('请设置导航');
        }
        $view->setViewDirectoryPath(ROOT_PUBLIC . DS . 'resource' . DS . 'template' . DS . 'default' . DS . 'view');

        $config = new Config();
        $configInfo = $config->getConfigBaseList();
        $configInfo = array_column($configInfo, 'cb_value', 'cb_name');
        $model = new Model();
        //分类
        $categoryNewsList = $model->getCategoryList('news', 0);
        $categoryProductList = $model->getCategoryList('product', 0);
        $view->assign('category_news', $categoryNewsList);
        $view->assign('category_product', $categoryProductList);
        $view->assign('site_name', $configInfo['site_name']);
        $view->assign('title', $title);
        $view->assign('position', $position);
    }

    public function detailView(Request $reqeust)
    {
        $model = new Model();
        $view = container('view');
        $paramInfo = $reqeust->getParams();
        $modelId = $paramInfo[0];
        DB::exec("update zq_model_list set ml_view_nums=ml_view_nums+1 where zt_id=1 and ml_id={$modelId}");
        $modelInfo = $model->getInfo(
            $modelId,
            array('requestField' => 1, 'requestAddition' => 1, 'requestFieldDec' => 1)
        );
        //dd($modelInfo);
        $modelDefine = Define::getModelDefine();
        $modelCategoryName = $modelDefine[$modelInfo['list']['ml_model_name']]['dec'];

        $categroyInfo = $model->getCategoryInfo($modelInfo['list']['ml_category_id']);
        $categroyName = $categroyInfo['mc_name'];

        $this->viewCommon(
            $view,
            $modelInfo['list']['ml_title'],
            "<a href='/'>首页</a> / <a> {$modelCategoryName} </a> / <a href='/index/index/list-view/product/{$modelInfo['list']['ml_category_id']}'> {$categroyName} </a>"
        );
        $view->assign('info', $modelInfo);

        return $view->render('detail');
    }

    public function listView(Request $reqeust)
    {
        $model = new Model();
        $view = container('view');

        $paramInfo = $reqeust->getParams();
        $modelName = $paramInfo[0];
        $categoryId = $paramInfo[1];

        $categoryInfo = $model->getCategoryInfo($categoryId);
        $view->assign('category_name', $categoryInfo['mc_name']);

        $categoryDec = $modelName == 'product' ? '产品中心' : '新闻中心';
        $this->viewCommon(
            $view,
            $categoryInfo['mc_name'] . ($modelName == 'product' ? '-产品中心'  : '-新闻中心'),
            "<a href='/'>首页</a> / <a>{$categoryDec}</a> / <a>{$categoryInfo['mc_name']}</a>'"
        );

        //总数量
        if ($categoryId) {
            $where[] = "ml_category_id={$categoryId}";
        }
        $pageInfo = $model->getList(array('where' => $where, 'col' => array('count(ml_id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 25;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $model->getList(array(
            'where' => $where,
            'order' => 'ml_id desc',
            'limit' => $pageNum,
            'offset' => ($page - 1) * $pageNum
        ));

        $view->assign('page', $page);
        $view->assign('nums', $pageTotalNum);
        $view->assign('list', $list);
        $view->assign('pages', $pageHtml);

        $templateFile = $modelName == 'product' ? 'product-list' : 'news-list';

        return $view->render($templateFile);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $view = container('view');
        $this->viewCommon($view, '首页', 'title');
        $model = new Model();

        //新闻
        $newsList = $model->getList(array(
            'limit' => 10,
            'col' => 'ml_id,ml_add_time,ml_title',
            'order' => 'ml_id desc',
            'where' => "ml_model_name='news'"
        ));
        $view->assign('news_list', $newsList);
        //产品
        $categoryProductList = $model->getCategoryList('product', 0);
        $productCategoryList = array_column($categoryProductList, 'mc_name', 'mc_id');
        $index = 1;
        $productList = array();
        foreach ($productCategoryList as $categoryProductId => $categoryProductName) {
            $productList[$categoryProductId] = array();
            $productList[$categoryProductId]['index'] = $index++;
            $productList[$categoryProductId]['category_name'] = $categoryProductName;
            $productList[$categoryProductId]['sub'] = $model->getList(array(
                'limit' => 5,
                'col' => 'ml_id,ml_add_time,ml_title,ml_pic_path',
                'order' => 'ml_id desc',
                'where' => "ml_model_name='product' and ml_category_id={$categoryProductId}"
            ));
        }
        //dd($productList);

        $view->assign('product_list', $productList);

        return $view->render('index');
    }
}
