<?php
/**
 * 本页以编辑会员列表页为例来展示，怎么通过配置文件，来快速的编辑某表的数据
 */
return array(
    'page_title' => '会员工号管理',
    'page_model' => '用户',
    'table_name' => 'zq_user', //表名
    'index_id' => 'u_id', //表自增长的主键
    'table_pre' => 'u', //表前缀 不要带_
    'is_del' => 0, //列表要不要删除功能
    'is_edit' => 0, //列表要不要删除功能
    'list_order' => 'u_id desc', //列表页默认排序
    'list_where' => "u_is_valid=1", //列表页默认的where条件

    /**
     * 下标是对应的数据库字段名
     * db_field_name:数据库字段名
     * title:列名
     * data_type:数据类型 类型列表请看 Common::getFieldTypeList()的key
     * is_show_list:是不是在列表中能显示
     * is_search:是不是能被搜索
     * search_type:搜索类型:like like_left like_right equal
     * is_insert:是不是可以在添加页面展示
     * tip:描述
     * is_insert_required:插入时，是不是必填
     * is_update:能被更新的字段
     * is_update_required:更新时，是不是必填
     * default:默认值，如果是下拉或单选多选，先用,分隔。
     * is_input_hidden:在编辑或添加表单是不是要隐藏
     */
    'col' => array(
        'u_id' => array(
            'title' => 'ID',
            'data_type' => 'string',
            'is_show_list' => 1,
            'db_field_name'=> 'u_id'
        ),
        'u_number' => array(
            'title' => '工号',
            'data_type' => 'string',
            'is_update'=> 1,
            'is_show_list' => 1,
            'is_update_required' => 1,
            'db_field_name'=> 'u_number'
        ),
    ),
);