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

/**
 * model数据格式标准格式为:
 * array('list'=> array('list'=>array('model_list表内容'), 'field'=> array('model_field表内容'), 'addition'=> array('model_addition表内容'), 'other'=>array(其它信息))
 * Class Model
 * @package app\Admin\Model
 */
class Model
{

    /**
     * @param $modelId
     * @param array $option array('requestField'=>'是不是要附加filed表', 'requestAddition'=>'是不是要附加addition表', 'requestFieldDec'=>'是不是要加上Field的描述，这个数据从[配置中心->模型配置]里来')
     * @return mixed
     */
    function getInfo($modelId, $option = array())
    {
        $join = array();
        if ($option['requestAddition']) {
            $join = array('table' => 'zq_model_addition', 'type' => 'left', 'condition' => 'ma_ml_id=ml_id');
        }

        $info = DB::select(array(
            'table' => 'zq_model_list',
            'col' => $option['col'],
            'where' => "ml_id={$modelId}",
            'join' => $join,
            'limit' => 1
        ));
        //echo DB::getLastSql();
        $info = current($info);
        //$info['ma_content'] = htmlentities($info['ma_content']);
        $info = $this->groupModelInfo($info);
        if ($option['requestField']) {
            $fieldList = DB::select(array(
                'table' => 'zq_model_field',
                'where' => "mf_ml_id={$modelId}",
                'col' => '*,mf_key as cm_key', //这里这么做是为了兼容编辑页里的field列表和加载配置
            ));
            if ($option['requestFieldDec']) {
                $config = new Config();
                $configList = $config->getConfigModelList($info['list']['ml_model_name']);
                $configList = current($configList);
                $configList = array_column($configList, 'cm_dec', 'cm_key');
                $configKeys = array_keys($configList);
                foreach ($fieldList as $key => $fieldInfo) {
                    //如果配置里没有，但原来的key没删除的，则不显示
                    if (!in_array($fieldInfo['mf_key'], $configKeys)) {
                        unset($fieldList[$key]);
                        continue;
                    }
                    //下面2行这么做是为了兼容编辑页里的field列表和加载配置
                    $fieldList[$key]['cm_dec'] = $configList[$fieldInfo['mf_key']];
                    $fieldList[$key]['mf_dec'] = $configList[$fieldInfo['mf_key']];
                }
            }
            //echo DB::getLastSql();
            $info['field'] = $fieldList;
        }
        //dd($info);
        //开始格式化
        return $info;
    }

    /**
     * @param $option 同select的搜索
     * @return mixed
     */
    function getList($option)
    {
        $option['table'] = 'zq_model_list';
        $list = DB::select($option);
        //echo DB::getLastSql();
        return $list;
    }

    /**
     * @param $categoryInfo
     * array('action'=>'add' 值为add或edit, 'model_name' => 'news', 'parent_id' => 0, 'category_name' => 'abc', 'id'=> 1 如果action为edit则这个id为必传 )
     * @return array
     */
    function categoryEdit($categoryInfo)
    {
        //判断
        $error = array();
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
        if ($error) {
            return Admin::commonReturn(0, $error);
            //return array('ack' => 0, 'msg' => $error);
        }
        //处理
        //dd($categoryInfo);
        $result = 0;
        $dbInfo = array(
            'mc_update_time' => time(),
            'mc_model_name' => $categoryInfo['model_name'],
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
            $option['col'] = 'mc_id,mc_name,mc_parent_id,mc_model_name';
        }
        $whereArr = array();
        array_push($whereArr, "zt_id={$ztId} and mc_model_name='{$modelName}'");
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
                    <a title=\"编辑\" href=\"javascript:;\" onclick=\"add_edit('编辑','/admin/model/category-edit-view/{$info['mc_model_name']}/edit/{$info['mc_id']}','','300')\"
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
    function getCategorySelectHtml($modelName, $option = array())
    {
        //dd($parentId);
        //dd($option[selectId]);
        //echo $sql;
        //dd($list);
        $list = $this->getCategoryList($modelName, $option['parentId']);
        $list = $this->getCategoryArr($list, $option['parentId'] ? $option['parentId'] : 0);
        //dd($list);

        $html = "<select name=\"{$option['selectName']}\" id='{$option['selectName']}' aria-required=\"true\" aria-invalid=\"false\">";
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

    /**
     * 返回表格前缀和数据结构的前缀对应关系
     * @return array
     */
    function getInputTableKeyArr()
    {
        return array('list' => 'ml', 'field' => '', 'addition' => 'ma');
    }

    /**
     * 把传来的数据，按数据库来分组 比如list开头 则放到list组中，且key的list_换成ml_ 如果ml_开头，则放到list组中
     * 比如list对应的是model_list表 field对应的是model_field addition对应的是model_addition
     * @param $info
     * @return array
     */
    function groupModelInfo($info)
    {
        //dd($info);
        $arr = array();
        $arr['list'] = array();
        $arr['field'] = array();
        $arr['addition'] = array();
        //对应的新表的key
        $newKeyArr = $this->getInputTableKeyArr();
        $newKeyArrChange = array_flip($newKeyArr);
        foreach ($info as $key => $value) {
            $keyArr = explode('_', $key);
            //dd($keyArr);
            $tableKey = $keyArr[0];
            if (2 == strlen($tableKey)) {
                //是表的字段 表前缀是2位，这里用来格式化从数据库来的数据
                $newKey = $newKeyArrChange[$tableKey] ? $newKeyArrChange[$tableKey] : 'other';

                $arr[$newKey][$key] = $value;
            } else {
                unset($keyArr[0]);
                if (count($keyArr)) {
                    $newKey = ($newKeyArr[$tableKey] ? $newKeyArr[$tableKey] . '_' : '') . implode('_', $keyArr);
                } else {
                    $tableKey = 'other';
                    $newKey = $key;
                }
                //dd($tableKey);
                //dd($newKey);
                $arr[$tableKey][$newKey] = $value;
                //dd($arr);
                //exit;
            }
        }
        //dd($arr);
        return $arr;
    }

    /**
     * 编辑资料，本function完全只是针对添加或修改资料里传来的数据
     */
    function edit()
    {
        //分组
        $data = post();
        //内容
        $data['addition_content'] = $data['editorValue'];
        $info = $this->groupModelInfo($data);
        $id = $info['other']['id'];
        //dd($info);
        //dd($info);
        //exit;
        //判断
        $error = array();
        $stringValidator = v::stringType()->length(1, 5000);
        if (!$stringValidator->validate($info['list']['ml_title'])) {
            $error[] = '标题不能为空';
        }
        if (strlen($info['list']['ml_category_id'] < 1)) {
            $error[] = '分类不能为空';
        }
        if (strlen($info['addition']['ma_content']) < 1) {
            $error[] = '内容不能为空';
        }
        if ($error) {
            return Admin::commonReturn(0, $error);
        }
        //逻辑

        //传图片
        $request = container('request');
        $fileUploadResult = array();
        $uploadDir = 'uploads' . DS . date('Y-m-d');
        try {
            $fileUploadResult = $request->upload('list_pic_path', $uploadDir,
                array('allowFile' => array('image/png', 'image/gif', 'image/jpg', 'image/jpeg')));
            if (!$fileUploadResult['ack']) {
                return Admin::commonReturn(0, $fileUploadResult['msg']);
            }
        } catch (\Exception $e) {
            $fileUploadResult['ack'] = 0;
            $fileUploadResult['msg'] = $e->getMessage();
        }
        //dd($fileUploadResult);
        /*dd($fileUploadResult);
        exit;*/
        if ($fileUploadResult['ack']) {
            $info['list']['ml_pic_path'] = $uploadDir . DS . $fileUploadResult['msg']['name'];
        }
        //如果没有更新图片则unset
        if (!strlen($info['list']['ml_pic_path'])) {
            unset($info['list']['ml_pic_path']);
        }
        //exit;
        //exit;

        $ztId = session('ztId');
        $userId = session('userId');
        $dbInfoList = $info['list'];
        $fieldList = $info['field'];
        $dbInfoAddition = $info['addition'];
        //dd($fieldList);

        $dbInfoList['zt_id'] = $ztId;
        $dbInfoList['ml_update_time'] = time();

        //$dbInfoField['zt_id'] = $ztId;
        //$dbInfoField['me_update_time'] = time();

        $dbInfoAddition['zt_id'] = $ztId;
        $dbInfoAddition['ma_update_time'] = time();
        if ('edit' == $data['action']) {

        } else {
            $dbInfoList['ml_add_time'] = time();
            //$dbInfoField['me_add_time'] = time();
            $dbInfoAddition['ma_add_time'] = time();
            $dbInfoList['ml_add_user_id'] = $userId;
            //$dbInfoField['me_add_user_id'] = $userId;
            $dbInfoAddition['ma_add_user_id'] = $userId;
        }
        //开始更新或添加
        $result = 1;
        DB::beginTransaction();
        if ('edit' == $data['action']) {
            $modelListSec = DB::update('zq_model_list', $dbInfoList, "ml_id={$id}");
            $modelAdditionSec = DB::update('zq_model_addition', $dbInfoAddition, "ma_ml_id={$id}");
            $modelFieldError = 0;

            //dd($fieldList);
            foreach ($fieldList as $fieldKey => $fieldValue) {
                $fieldDbInfo = array();
                $fieldDbInfo['mf_key'] = $fieldKey;
                $fieldDbInfo['mf_value'] = $fieldValue;
                //$fieldDbInfo['mf_ml_id'] = $modelListId;
                //$fieldDbInfo['zt_id'] = $ztId;
                //$fieldDbInfo['mf_add_user_id'] = $userId;
                $fieldDbInfo['mf_update_time'] = time();
                //$fieldDbInfo['mf_add_time'] = time();

                if( DB::select( array('table'=>'zq_model_field', 'col'=>'mf_id', 'where'=>"mf_key='{$fieldKey}' and mf_ml_id={$id}" ) ))
                {
                    $modelFieldSec = DB::update('zq_model_field', $fieldDbInfo, "mf_key='{$fieldKey}' and mf_ml_id={$id}");
                }else
                {
                    $fieldDbInfo['mf_ml_id'] = $id;
                    $fieldDbInfo['zt_id'] = $ztId;
                    $fieldDbInfo['mf_add_user_id'] = $userId;
                    $fieldDbInfo['mf_update_time'] = time();
                    $fieldDbInfo['mf_add_time'] = time();
                    $modelFieldSec = DB::insert('zq_model_field', $fieldDbInfo);
                }
                if (0 == $modelFieldSec) {
                    $modelFieldError++;
                }
            }

            if ($modelListSec && $modelAdditionSec && !$modelFieldError) {
                DB::commit();
                $result = 1;
            } else {
                DB::rollBack();
                $result = 0;
            }

        } else {
            //dd($dbInfoList);
            $modelListId = DB::insert('zq_model_list', $dbInfoList);
            $dbInfoField['me_ml_id'] = $modelListId;
            $dbInfoAddition['ma_ml_id'] = $modelListId;
            //exit;

            //dd($dbInfoAddition);
            //dd($dbInfoAddition);
            $modelAdditionId = DB::insert('zq_model_addition', $dbInfoAddition);

            $modelFieldError = 0;
            foreach ($fieldList as $fieldKey => $fieldValue) {
                $fieldDbInfo = array();
                $fieldDbInfo['mf_key'] = $fieldKey;
                $fieldDbInfo['mf_value'] = $fieldValue;
                $fieldDbInfo['mf_ml_id'] = $modelListId;
                $fieldDbInfo['zt_id'] = $ztId;
                $fieldDbInfo['mf_add_user_id'] = $userId;
                $fieldDbInfo['mf_update_time'] = time();
                $fieldDbInfo['mf_add_time'] = time();

                $modelFieldId = DB::insert('zq_model_field', $fieldDbInfo);
                if (0 == $modelFieldId) {
                    $modelFieldError++;
                }
            }

            //dd($modelListId);
            //dd($modelAdditionId);

            if ($modelAdditionId && $modelListId && !$modelFieldError) {
                DB::commit();
                $result = 1;
            } else {
                DB::rollBack();
                $result = 0;
            }

        }
        //exit;
        //返回
        return Admin::commonReturn($result);
    }
}