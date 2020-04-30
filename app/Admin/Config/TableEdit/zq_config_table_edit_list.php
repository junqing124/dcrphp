<?php
/**
 * 本页以编辑会员列表页为例来展示，怎么通过配置文件，来快速的编辑某表的数据
 */
return array(
    'page_title' => '单表管理列表',
    'page_model' => '系统配置',
    'table_name' => 'zq_config_table_edit_list', //表名
    'index_id' => 'ctel_id', //表自增长的主键
    'table_pre' => 'ctel', //表前缀 不要带_
    'is_del' => 1, //列表要不要删除功能
    'is_add' => 1, //列表要不要添加功能
    'is_edit' => 1, //列表要不要更新功能
    'list_order' => 'ctel_id desc', //列表页默认排序
    'list_where' => "", //列表页默认的where条件
    'edit_window_width'=> '90%', //添加编辑框宽
    'edit_window_height'=> '90%', //添加编辑框高
    'addition_option_html' => '<a title="字段" href="javascript:;" onclick="open_iframe(\'配置字段\',\'/admin/tools/table-edit-list-view/zq_config_table_edit_item?ctei_ctel_id={db.index_id}&list_where=ctei_ctel_id={db.index_id}\',\'95%\',\'95%\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont-menu"></i></a>', //操作的额外添加
    'allow_config_from_request' =>'', //配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get('list_order')用,号拼接

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
        'ctel_id' => array(
            'title' => 'ID',
            'data_type' => 'string',
            'is_show_list' => 1,
            'db_field_name'=> 'ctel_id'
        ),
        'ctel_key' => array(
            'title' => '关键字',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_search' => 1,
            'search_type'=> 'like',
            'is_insert' => 1,
            'tip' => '小写英文字母开头，只能小写英文及数字',
            'is_insert_required' => 1,
            'db_field_name'=> 'ctel_key'
        ),
        'ctel_page_title' => array(
            'title' => '页面标题',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'db_field_name'=> 'ctel_page_title',
            'is_insert_required'=> 1,
            'is_update'=> 1,
            'is_update_required' => 1,
        ),
        'ctel_page_model' => array(
            'title' => '模块名',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_page_model',
            'is_insert_required'=> 1,
            'is_update_required' => 1,
        ),
        'ctel_table_name' => array(
            'title' => '表名',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_table_name',
            'is_insert_required'=> 1,
            'is_update_required' => 1,
        ),
        'ctel_index_id' => array(
            'title' => '主键名',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_index_id',
            'is_insert_required'=> 1,
            'is_update_required' => 1,
        ),
        'ctel_table_pre' => array(
            'title' => '表前缀',
            'tips'=>'不要以_结尾',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_table_pre',
            'is_insert_required'=> 1,
            'is_update_required' => 1,
        ),
        'ctel_is_del' => array(
            'title' => '删除功能',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_is_del',
            'default'=> '是',
        ),
        'ctel_is_add' => array(
            'title' => '添加功能',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_is_add',
            'default'=> '是',
        ),
        'ctel_is_edit' => array(
            'title' => '编辑功能',
            'data_type' => 'checkbox',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_is_edit',
            'default'=> '是',
        ),
        'ctel_list_order' => array(
            'title' => '默认的排序',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_list_order',
        ),
        'ctel_list_where' => array(
            'title' => '默认的where条件',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_list_where',
        ),
        'ctel_edit_window_width' => array(
            'title' => '编辑窗口宽',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_edit_window_width',
        ),
        'ctel_edit_window_height' => array(
            'title' => '编辑窗口高',
            'data_type' => 'string',
            'is_show_list' => 1,
            'is_insert' => 1,
            'is_update'=> 1,
            'db_field_name'=> 'ctel_edit_window_height',
        ),
        'ctel_addition_option_html' => array(
            'title' => '操作里自定义额外html',
            'data_type' => 'text',
            'is_insert' => 1,
            'is_update'=> 1,
            'tip'=> '如果想在操作列里有额外的链接，可以在这里定义，支持db.index_id 表示取主键字段的值',
            'db_field_name'=> 'ctel_addition_option_html',
        ),
        'ctel_allow_config_from_request' => array(
            'title' => '操作里自定义额外html',
            'data_type' => 'text',
            'is_insert' => 1,
            'is_update'=> 1,
            'tip'=> '配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(\'list_order\')用,号拼接',
            'db_field_name'=> 'ctel_allow_config_from_request',
        ),
        'ctel_add_time' => array(
            'title' => '添加时间',
            'data_type' => 'date',
            'default' => time(),
            'is_insert' => 1,
            'db_field_name'=> 'ctel_add_time',
            'is_input_hidden'=> 1,
        ),
        'ctel_update_time' => array(
            'title' => '更新时间',
            'data_type' => 'date',
            'default' => time(),
            'is_update' => 1,
            'db_field_name'=> 'ctel_update_time',
            'is_input_hidden'=> 1,
        ),
        'ctel_add_user_id' => array(
            'title' => '添加人',
            'data_type' => 'date',
            'default' => session('userId'),
            'is_insert' => 1,
            'db_field_name'=> 'ctel_add_user_id',
            'is_input_hidden'=> 1,
        ),
    ),
);