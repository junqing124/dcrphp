<?php
/**
 * 本页以编辑会员列表页为例来展示，怎么通过配置文件，来快速的编辑某表的数据
 */

return array(
    'page_title' => '单表管理列表',
    'page_model' => '系统配置',
    'table_name' => 'zq_config_table_edit_item', //表名
    'index_id' => 'ctei_id', //表自增长的主键
    'table_pre' => 'ctei', //表前缀 不要带_
    'is_del' => 1, //列表要不要删除功能
    'is_add' => 1, //列表要不要添加功能
    'is_edit' => 1, //列表要不要更新功能
    'list_order' => 'ctei_id desc', //列表页默认排序
    'list_where' => "", //列表页默认的where条件
    'edit_window_width'=> '90%', //添加编辑框宽
    'edit_window_height'=> '90%', //添加编辑框高
    'addition_option_html' => '', //操作列的额外添加的html
    'allow_config_from_request' =>'list_where', //配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_where=u_id,那么实际使用的list_order=list_order配置和get('list_order')用,号拼接
    'add_page_addition_html'=>'<input type="hidden" name="ctei_ctel_id" value="{get.ctei_ctel_id}">', //添加页面form里额外的html
    'edit_page_addition_html'=>'', //编辑页面form里额外的html
    'add_button_addition_html'=>'?ctei_ctel_id={get.ctei_ctel_id}', //添加按钮额外的html
    'edit_button_addition_html'=>'', //编辑按钮额外的html

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
        'ctei_ctel_id' => array(
            'title' => '父表ID',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_ctel_id',
            'is_input_hidden'=> 1,
        ),
        'ctei_db_field_name' => array(
            'title' => '字段名',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_search' => 1,
            'search_type'=> 'like',
            'is_insert' => 1,
            'tip' => '小写英文字母开头，只能小写英文及数字',
            'is_insert_required' => 1,
            'is_update'=> 1,
            'is_update_required' => 1,
            'db_field_name'=> 'ctei_db_field_name'
        ),
        'ctei_title' => array(
            'title' => '标题',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_search' => 1,
            'search_type'=> 'like',
            'is_insert' => 1,
            'is_insert_required' => 1,
            'is_update'=> 1,
            'is_update_required' => 1,
            'db_field_name'=> 'ctei_title'
        ),
        'ctei_data_type' => array(
            'title' => '数据类型',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_search' => 1,
            'search_type'=> 'like',
            'is_insert' => 1,
            'is_insert_required' => 1,
            'is_update'=> 1,
            'tip'=> '数据类型 类型列表请看 Common::getFieldTypeList()的key',
            'is_update_required' => 1,
            'db_field_name'=> 'ctei_data_type'
        ),
        'ctei_is_show_list' => array(
            'title' => '列表中显示',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_show_list',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_search' => array(
            'title' => '列表中能搜索',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_search',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_insert' => array(
            'title' => '能添加',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_insert',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_insert_required' => array(
            'title' => '添加必填',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_insert_required',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_update' => array(
            'title' => '能更新',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_update',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_update_required' => array(
            'title' => '更新必填',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_update_required',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_is_input_hidden' => array(
            'title' => '是不是hidden',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctei_is_input_hidden',
            'is_update'=> 1,
            'default'=> '是',
        ),
        'ctei_search_type' => array(
            'title' => '搜索类型',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctei_search_type',
        ),
        'ctei_tip' => array(
            'title' => '提示',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctei_tip',
        ),
        'ctei_default' => array(
            'title' => '默认值',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctei_default',
        ),
        'ctei_add_time' => array(
            'title' => '添加时间',
            'data_type' => 'date',
            'default' => time(),
            'is_insert' => 1,
            'db_field_name'=> 'ctei_add_time',
            'is_input_hidden'=> 1,
        ),
        'ctei_update_time' => array(
            'title' => '更新时间',
            'data_type' => 'date',
            'default' => time(),
            'is_update' => 1,
            'db_field_name'=> 'ctei_update_time',
            'is_input_hidden'=> 1,
        ),
        'ctei_add_user_id' => array(
            'title' => '添加人',
            'data_type' => 'date',
            'default' => session('userId'),
            'is_insert' => 1,
            'db_field_name'=> 'ctei_add_user_id',
            'is_input_hidden'=> 1,
        ),
    ),
);