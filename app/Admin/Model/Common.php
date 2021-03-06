<?php


namespace app\Admin\Model;

use app\Admin\Model\Admin;
use app\Admin\Model\Config;
use dcr\Db;

class Common
{

    /**
     * 返回数据库保留字段
     * @return string[]
     */
    public static function getDbBaseField()
    {
        $list = array(
            'add_time', 'update_time', 'approval_status', 'add_user_id', 'zt_id',
        );
        return $list;
    }

    /**
     * 本function自1.0.3后作废 现在存数据库了
     * @return array[]
     */
    public static function getModelDefineAbandon()
    {
        return array(
            'news' => array('key' => 1, 'dec' => '新闻中心', 'name' => 'news',),
            'product' => array('key' => 2, 'dec' => '产品中心', 'name' => 'product',),
            'info' => array('key' => 3, 'dec' => '资料中心', 'name' => 'info',),
        );
    }

    public static function getFieldTypeList()
    {
        return array(
            array('name' => '单行文本', 'key' => 'string'),
            array('name' => '多行文本', 'key' => 'text'),
            array('name' => '单选框', 'key' => 'radio'),
            array('name' => '多选框', 'key' => 'checkbox'),
            array('name' => '下拉框', 'key' => 'select'),
            array('name' => '文件', 'key' => 'file'),
            array('name' => '时间', 'key' => 'date'),
        );
    }


    /**
     * 通过配置好的字段各属性来生成html
     * @param $configItemArr array('data_type'=>'数据类型','db_field_name'=>'数据库字段名','default'=>'默认值', 'is_input_hidden'=>'是不是hidden类型',如果是 则直接设置为hidden,这个只对date_type为date和string生效)
     * @param array $valueList 设置Input的值 比如想把site_name的值为 DcrPHP系统 则传入传情为 array('site_name'=>'DcrPHP系统');
     * @param array $varList 外部变量列表，这个是为了实现var.abc这样的配置项 一般传get_defined_vars()
     * @param array $option 额外的设置在这 array('input_name_pre'=>'input的name加上统一的前缀')
     * @return mixed
     */
    public static function generalHtmlForItem($configItemArr, $valueList = array(), $varList = array(), $option = array())
    {
        foreach ($configItemArr as $itemKey => $itemInfo) {
            $keyList = self:: getFieldTypeList();
            $keyList = array_column($keyList, 'key');
            if (!in_array($itemInfo['data_type'], $keyList)) {
                continue;
            }
            $html = '';

            //默认或设置值
            $default = $itemInfo['default_str'];
            if ('var.' == substr($default, 0, 4)) {
                $var = substr($default, 4);
                $default = $varList[$var];
            }

            $inputValue = isset($valueList[$itemInfo['db_field_name']]) ? $valueList[$itemInfo['db_field_name']] : $default;
            /*echo '<br><br><br>';
            dd($itemInfo['db_field_name']);
            dd($default);
            dd($valueList);
            dd($valueList['list_order']);
            dd($inputValue);*/
            $additionStr = '';
            $type = '';
            $inputNameId = $option['input_name_pre'] ? $option['input_name_pre'] . $itemInfo['db_field_name'] : $itemInfo['db_field_name'];
            switch ($itemInfo['data_type']) {
                case 'date':
                    $type = $itemInfo['is_input_hidden'] ? 'hidden' : 'text';
                    $html = "<input class='input-text' name='{$inputNameId}' id='{$inputNameId}' type='{$type}' value='{$inputValue}'>";
                    break;
                case 'string':
                    $type = $itemInfo['is_input_hidden'] ? 'hidden' : 'text';
                    $html = "<input class='input-text' name='{$inputNameId}' id='{$inputNameId}' type='{$type}' value='{$inputValue}'>";
                    break;
                case 'text':
                    $html = "<textarea name='{$inputNameId}' id='{$inputNameId}' class='textarea radius' >{$inputValue}</textarea>";
                    break;
                case 'radio':
                case 'checkbox':
                    $inputValueList = explode(',', $default);
                    foreach ($inputValueList as $inpValueDetail) {
                        if ($inpValueDetail == $inputValue || 1 == $inputValue) {
                            if (in_array($itemInfo['data_type'], array('radio','checkbox'))) {
                                $additionStr = ' checked ';
                            } else {
                                $additionStr = ' selected ';
                            }
                        }
                        $html .= "<label class='mr-10'><input type='{$itemInfo['data_type']}' {$additionStr} value='{$inpValueDetail}' name='{$inputNameId}'>{$inpValueDetail}</label>";
                    }
                    break;
                case 'select':
                    $inputValueList = explode(',', $default);
                    $html = "<select class='select' name='{$inputNameId}' id='{$inputNameId}'>";
                    $html .= "<option value=''>请选择</option>";
                    foreach ($inputValueList as $inpValueDetail) {
                        $additionStr = '';
                        if ($inpValueDetail == $inputValue) {
                            $additionStr = ' selected ';
                        }
                        $html .= "<option {$additionStr} value='{$inpValueDetail}'>{$inpValueDetail}</option>";
                    }
                    $html .= '</select>';
                    break;
                case 'file':
                    $html = "<input type='file'  name='{$inputNameId}' id='{$inputNameId}' >";
                    break;
                default:
                    $html = '';
                    break;
            }
            $configItemArr[$itemKey]['html'] = $html;
        }
        return $configItemArr;
    }

    /**
     * 通用的数据库表增改删 CUD:create update delete
     * @param $tableName 表名
     * @param $tablePreName 表前缀
     * @param $dbInfo 要添加或更新的数据，如果是删除，本字段为空
     * @param string $actionType 添加还是更新还是删除 add edit delete
     * @param array $option array('id'=>$id 如果是涉及到修改数据的话，要这个id,'check'=>array('a'=>array('type'=>requried a字段为必填), 'b'=>array('type'=>requried b字段为必填)))
     *
     * 案例
     *
     */
    public static function CUDDbInfo(
        $tableName,
        $tablePreName,
        $dbInfo,
        $actionType = 'insert',
        $option = array()
    ) {

        $tablePreName = '';
        if (!in_array($actionType, array('add', 'delete','edit'))) {
            throw new \Exception('当前action为' . $actionType . ',操作类型只允许insert update delete');
        }
        if (in_array($actionType, array('edit', 'delete')) && !isset($option['id'])) {
            throw new \Exception('如果是更新或删除，请设置主键id($option["id"])');
        }
        $result = 0;
        if ('delete' == $actionType) {
            //验证
            $info = DB::select(array(
                'table' => $tableName,
                'col' => $tablePreName . 'id',
                'where' => $tablePreName . "id={$option['id']}",
                'limit' => 1
            ));
            $info = current($info);

            if (!$info) {
                throw new \Exception('没有找到这个信息');
            }
            //逻辑
            $result = Db::delete($tableName, $tablePreName . "id={$option['id']}");
        } else {
            if ($option['check']) {
                foreach ($option['check'] as $fieldName => $detail) {
                    if ('required' == $detail['type'] && strlen($dbInfo[$fieldName]) < 1) {
                        throw new \Exception($fieldName . '-为必填项');
                    }
                    if ('number' == $detail['type'] && !is_numeric($dbInfo[$fieldName])) {
                        throw new \Exception($fieldName . '-为数字');
                    }
                }
            }

            //处理
            if ('edit' == $actionType) {
                $result = Db::update($tableName, $dbInfo, $tablePreName . "id='{$option['id']}'");
            } else {
                if ('add' == $actionType) {
                    if (!isset($dbInfo['add_user_id'])) {
                        $dbInfo['add_user_id'] = session('userId');
                    }
                    if (!isset($dbInfo['zt_id'])) {
                        $dbInfo['zt_id'] = session('ztId');
                    }
                    $result = Db::insert($tableName, $dbInfo);
                }
            }
        }

        return Admin::commonReturn($result);
    }
}
