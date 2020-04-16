<?php


namespace app\Model;

use app\Admin\Model\Admin;
use dcr\Db;

class Common
{
    public static function getModelDefine()
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
            array('name' => '单行文本', 'key' => 'varchar'),
            array('name' => '多行文本', 'key' => 'text'),
            array('name' => '单选框', 'key' => 'radio'),
            array('name' => '多选框', 'key' => 'checkbox'),
            array('name' => '下拉框', 'key' => 'select'),
            array('name' => '文件', 'key' => 'file'),
        );
    }

    /**
     * @param $tableName 表名
     * @param $tablePreName 表前缀
     * @param $dbInfo 要添加或更新的数据，如果是删除，本字段为空
     * @param string $actionType 添加还是更新还是删除 insert update delete
     * @param array $option array('id'=>$id 如果是修改的话，要用这个id,'check'=>array('a'=>array('type'=>requried a字段为必填), 'b'=>array('type'=>requried b字段为必填)))
     *
     * 案例
     *
     */
    public static function addOrEditDbInfo(
        $tableName,
        $tablePreName,
        $dbInfo,
        $actionType = 'insert',
        $option = array()
    ) {
        if (in_array($actionType, array('edit', 'delete')) && !isset($option['id'])) {
            throw new \Exception('如果是更新或删除，请设置主键id($option["id"])');
        }
        $result = 0;
        if ('delete' == $actionType) {
            //验证
            $info = DB::select(array(
                'table' => $tableName,
                'col' => $tablePreName . '_id',
                'where' => $tablePreName . "_id={$option['id']}",
                'limit' => 1
            ));
            $info = current($info);

            if (!$info) {
                throw new \Exception('没有找到这个信息');
            }
            //逻辑
            $result = DB::delete($tableName, $tablePreName . "_id={$option['id']}");
        } else {
            //设置通用字段 update_time add_user_id zt_id
            if (!isset($dbInfo[$tablePreName . '_update_time'])) {
                $dbInfo[$tablePreName . '_update_time'] = time();
            }

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
                $result = DB::update($tableName, $dbInfo, $tablePreName . "_id='{$option['id']}'");
            } else {
                if ('add' == $actionType) {
                    if (!isset($dbInfo[$tablePreName . '_add_user_id'])) {
                        $dbInfo[$tablePreName . '_add_user_id'] = session('userId');
                    }
                    if (!isset($dbInfo['zt_id'])) {
                        $dbInfo['zt_id'] = session('ztId');
                    }
                    if (!isset($dbInfo[$tablePreName . '_add_time'])) {
                        $dbInfo[$tablePreName . '_add_time'] = time();
                    }
                    $result = DB::insert($tableName, $dbInfo);
                }
            }
        }

        return Admin::commonReturn($result);
    }
}
