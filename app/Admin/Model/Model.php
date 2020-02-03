<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use Aura\SqlQuery\QueryFactory;
use dcr\Db;
use dcr\Session;
use Respect\Validation\Validator as v;

class Model
{

    /**
     * @param $categoryInfo
     * array('action'=>'add' 值为add或edit, 'model_name' => 'news', 'parent_id' => 0, 'category_name' => 'abc', 'id'=> 1 如果action为edit则这个id为必传 )
     * @return array
     */
    function categoryEdit($categoryInfo)
    {
        //判断
        $stringValidator = v::stringType()->length(1, 50);
        if (!$stringValidator->validate($categoryInfo['action'])) {
            $error[] = 'Action长度不符合[1-50]';
        }
        if ('edit' == $categoryInfo['action']) {
            if (!$stringValidator->validate($categoryInfo['mc_id'])) {
                $error[] = '主ID[mc_id]长度不符合[1-50]';
            }
        }
        if (!$stringValidator->validate($categoryInfo['model_name'])) {
            $error[] = '模型名长度不符合[1-50]';
        }
        if (!$stringValidator->validate($categoryInfo['category_name'])) {
            $error[] = '分类长度不符合[1-50]';
        }
        //处理
        //dd($categoryInfo);
        $result = 0;
        $ztId = \session('ztId');
        $dbInfo = array(
            'mc_update_time' => time(),
            'mc_model' => $categoryInfo['model_name'],
            'mc_name' => $categoryInfo['category_name'],
            'mc_parent_id' => $categoryInfo['parent_id'],
        );
        if ('add' == $categoryInfo['action']) {
            $dbInfo['mc_add_time'] = time();
            $dbInfo['mc_add_user_id'] = session('userId');
            $dbInfo['zt_id'] = session('ztId');
            $result = DB::insert('zq_model_category', $dbInfo);

        } else {
            //dd($categoryInfo);
            if ('edit' == $categoryInfo['action']) {
                $result = DB::update('zq_model_category', $dbInfo, "mc_id={$categoryInfo['id']}");
            }
        }

        return Admin::commonReturn($result);
    }

    function getCategoryInfo($categoryId, $option = array())
    {
        $info = DB::select(array(
            'table' => 'zq_model_category',
            'col' => $option['col'],
            'where' => "mc_id={$categoryId}",
            'limit' => 1
        ));
        $info = current($info);
        return $info;
    }

    function getCategoryList($modelName, $parentId = null, $option = array())
    {
        $ztId = session('ztId');
        if (!$option['col']) {
            $option['col'] = 'mc_id,mc_name,mc_parent_id,mc_model';
        }
        $whereArr = array();
        array_push($whereArr, "zt_id={$ztId} and mc_model='{$modelName}'");
        if ($parentId != null) {
            array_push($whereArr, "mc_parent_id={$parentId}");
        }

        $list = DB::select(array('table' => 'zq_model_category', 'col' => $option['col'], 'where' => $whereArr));

        return $list;
    }

    function getCategoryTrHtml($modelName, $parentId = null)
    {

        $list = $this->getCategoryList($modelName, $parentId);
        $list = $this->getCategoryArr($list, $parentId ? $parentId : 0);
        $html = '';
        if ($list) {
            $html = $this->getCategoryTrDetailHtml($list);
        }
        return $html;
    }

    function getCategoryTrDetailHtml($list)
    {
        static $optionHtml = '';
        foreach ($list as $info) {
            $optionHtml .= "<tr class='text-l'>
                <td>" . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $info['level']) . "{$info['mc_name']}</td>
                <td class='td-manage'>
                    <a title=\"编辑\" href=\"javascript:;\" onclick=\"add_edit('编辑','/admin/model/category-edit-view/{$info['mc_model']}/edit/{$info['mc_id']}','','300')\"
                       class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6df;</i></a>";
            if (!is_array($info['sub'])) {
                $optionHtml .= "<a title=\"删除\" href=\"javascript:;\" onclick=\"del({$info['mc_id']})\" class=\"ml-5\"
                       style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6e2;</i></a>";

            }
            $optionHtml .= "</td>
            </tr>";
            //dd($info['sub']);
            //var_dump(count($info['sub'])>0);
            if (is_array($info['sub'])) {
                $this->getCategoryTrDetailHtml($info['sub']);
            }
        }
        return $optionHtml;
    }

    /**
     * 获取分类的select的html
     * @param $modelName
     * @param array $option 附加参数
     * array(
     *  'parentId'=> 父类ID
     *  'selectId'=> 选中的分类
     *  'subEnabled'=> 只让选最末级的分类
     *  'selectName'=> 这个select的名字
     * )
     * @return string
     */
    function getCategorySelectHtml($modelName, $option = array( ))
        //$parentId = null, $selectId = null, $subEnabled = 0)
    {
        //dd($parentId);
        //dd($selectId);
        //echo $sql;
        //dd($list);
        $list = $this->getCategoryList($modelName, $option['parentId']);
        $list = $this->getCategoryArr($list, $option['parentId'] ? $option['parentId'] : 0);
        //dd($list);

        $html = "<select name=\"{$option['selectName']}\" id='{$option['selectName']}' class=\"select valid\" aria-required=\"true\" aria-invalid=\"false\">";
        $html .= "<option value=\"0\">一级分类</option>";
        //dd($list);
        if ($list) {
            $html .= $this->getCategorySelectOptionHtml($list, $option['selectId'], $option['subEnabled']);
        }
        //<option value=\"1\">新闻资讯</option>
        //<option value=\"11\">├行业动态</option>
        //<option value=\"12\">├行业资讯</option>
        //<option value=\"13\">├行业新闻</option>
        $html .= "</select>";
        return $html;
    }

    function getCategorySelectOptionHtml($list, $selectId = null, $subEnabled = 0)
    {
        static $optionHtml = '';
        foreach ($list as $info) {
            $optionAdditionStr = '';
            //dd($selectId);
            //dd($info['mc_id']);
            //echo '<hr>';
            if ($selectId == $info['mc_id']) {
                $optionAdditionStr = ' selected ';
            }
            if (is_array($info['sub']) && $subEnabled) {
                $optionAdditionStr .= ' disabled ';
            }
            $txtAdd = '';
            if (0 != $info['level']) {
                $txtAdd = str_repeat('--', $info['level']) . '├';
            }
            $optionHtml .= "<option value='{$info['mc_id']}' {$optionAdditionStr}>{$txtAdd}{$info['mc_name']}</option>";
            //dd($info['sub']);
            //var_dump(count($info['sub'])>0);
            if (is_array($info['sub'])) {
                $this->getCategorySelectOptionHtml($info['sub'], $selectId, $subEnabled);
            }
        }
        return $optionHtml;
    }

    function getCategoryArr($list, $parentId, $level = 0)
    {
        $tree = '';
        foreach ($list as $key => $value) {
            //dd($value);
            //echo $parentId;
            if ($value['mc_parent_id'] == $parentId) {
                //echo 'a';
                $value['level'] = $level;
                $value['sub'] = $this->getCategoryArr($list, $value['mc_id'], $level + 1);
                $tree[] = $value;
                unset($list[$key]);
            }
        }
        return $tree;
    }

    function deleteCategory($id)
    {

        //验证
        $info = DB::select(array(
            'table' => 'zq_model_category',
            'col' => 'mc_id',
            'where' => "mc_id={$id}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个信息');
        }
        //逻辑
        $result = DB::delete('zq_model_category', "mc_id={$id}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }
}