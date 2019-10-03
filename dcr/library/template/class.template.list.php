<?php

defined('IN_DCR') or exit('No permission.');
require_once( WEB_CLASS . '/template/interface.tag.compile.php' );

/**
 * list块标签处理类 这是一个核心类，其它要获取列表的tag都可以调用这个类，本类一定要存在
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0.0
 * @package class
 * @since 1.0.9
*/

class cls_template_list extends cls_template implements interface_tag_compile
{
    private $tag_info;//'block_content'=>标签全部内容 'tag_name'=>标签名 'attr_array'=>属性数组 'block_notag_content'=>标签内容(除{dcr:*} 及{/dcr:*})
    private $attr_array;//属性数组 '属性名'=>属性值
    private $compile_content; //编译好的内容
    private $block_content; //标签内容
    private $tag_name; //标签名
   
    /**
     * 构造函数
     * @param string $tag_info
     * @param array $attr_array 标签属性
     * @return
     */
    function __construct($tag_info)
    {
        $this->tag_info = $tag_info;
        $this->attr_array = $tag_info['attr_array'];
        $this->block_content = $tag_info['block_content'];
        $this->tag_name = $tag_info['tag_name'];
        //echo $block_first_line;
        $this->compile_tag();
    }
   
    /**
     * 编译tag
     * @param string $tag_name 标签名
     * @param array $attr_array 标签属性
     * @return
     */
    function compile_tag()
    {
        $tag_info = $this->tag_info;
        $compile_content = $tag_info['block_content']; //标签内容
        $attr_array = $tag_info['attr_array']; //属性列表
        $table_name = $attr_array['table']; //表名
        $row = empty( $attr_array['row'] ) ? 10 : $attr_array['row'];
        $limit = empty( $attr_array['limit'] ) ? "\$start,\$page_list_num" : $attr_array['limit'];
       
        if(empty($table_name)) return false;
       
        //得出第一行内容即{dcr:list table='test'}这行的内容
        $block_first_line = parent::get_block_first_line($tag_info);
       
        //把{dcr:list *} 处理成sql
        $php_code = "<?php \r\n\$page_list_num = " . $row . ";  //每页显示9条";
        $php_code .= "\r\nglobal \$page;  //总页数";
        $php_code .= "\r\n\$total_page = 0;  //总页数";
        $php_code .= "\r\n\$cur_page = isset(\$page) ? (int)\$page : 1;";
        $php_code .= "\r\n\$start = (\$cur_page-1) * \$page_list_num;";
        $php_code .= "\r\n \t\$cls_data = cls_app:: get_data('" . $table_name . "');";
        $php_code .= "\r\n\t\$data_list = \$cls_data->select_ex(array('col'=>'" . $attr_array['col'] .
                         "', 'where'=>'" . $attr_array['where'] .
                         "', 'order'=>'" . $attr_array['order'] .
                         "', 'limit'=>\"" . $limit .
                         "\", 'group'=>'" . $attr_array['group'] . "'));";
        if( $attr_array['row'] )
        {
            $php_code .= "\r\n\$page_num_info = \$cls_data-> select_one_ex(array('col'=>'count(id) as c_id', 'where'=>'" . $attr_array['where'] . "', 'group'=>'" . $attr_array['group'] . "'));";                                 $php_code .= "\r\n\$page_num = \$page_num_info['c_id'];";
            $php_code .= "\r\n\$total_page = ceil(\$page_num/\$page_list_num);    //总页数;";
        }
        $php_code .= "\r\n\tforeach(\$data_list as \$data_info)\r\n\t{";
        $php_code .= "\r\n?>";
        $compile_content = $php_code . $compile_content;
       
        //处理inner_tag
        $compile_inner = parent:: compile_inner_tag($tag_info['block_notag_content']);
        $compile_content = str_replace($tag_info['block_notag_content'], $compile_inner, $compile_content);
       
        //去掉头和尾的标签
        $compile_content = str_replace($block_first_line, '', $compile_content);
        $compile_content = str_replace('{/dcr:' . $tag_info['tag_name'] . '}', "<?php \r\n\t}\r\n\tunset(\$cls_data, \$data_list); \r\n?>", $compile_content);
        $this->compile_content = $compile_content;
    }
   
   
    /**
     * 获取编译后的内容
     * @param string $tag_name 标签名
     * @param array $attr_array 标签属性
     * @return
     */
    function get_content()
    {
        return $this->compile_content;
    }
   
    /**
     * 编译块内标签
     * @return
     */   
    function compile_block_inner_tag()
    {
    }
}

?>