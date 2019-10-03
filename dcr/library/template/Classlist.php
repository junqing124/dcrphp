<?php

defined('IN_DCR') or exit('No permission.'); 
require_once( WEB_CLASS . '/template/interface.tag.compile.php' );

/**
 * page单标签处理类
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

class cls_template_classlist extends cls_template implements interface_tag_compile
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
		
		//编译内容
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
		$type = $attr_array['type'];
		$grade = isset($attr_array['grade']) ? intval( $attr_array['grade'] ) : 0;
		
		$php_code = '';
		if( 0 == $grade )
		{
			//如果是第一个的话。就要获取classlist
			$php_code = "<?php \r\n\t\$cls_class = cls_app:: get_" . $type . "();";
			$php_code .= "\r\n\t\$" . $type . "_class_0_list = \$cls_class-> get_class_list();";
			$php_code .= "\r\n\tif( \$" . $type . "_class_0_list )\r\n\t{";
			$php_code .= "\r\n\t\tforeach( \$" . $type . "_class_0_list as \$" . $type . "_class_0_key=>\$" . $type . "_class_0_info )\r\n\t\t{\r\n?>";			
		} else
		{
			$parent_grade = $grade - 1;
			$php_code = "<?php\r\n\tif( \$" . $type . "_class_" . $parent_grade . "_info['sub_class'] )\r\n\t{";
			$php_code .= "\r\n\t\tforeach( \$" . $type . "_class_" . $parent_grade . "_info['sub_class'] as \$" . $type . "_class_" . $grade . "_key=>\$" . $type . "_class_" . $grade . "_info )\r\n\t\t{\r\n?>";
		}
		$compile_content = str_replace( $compile_content, $php_code, $compile_content);
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