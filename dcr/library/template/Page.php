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

class cls_template_page extends cls_template implements interface_tag_compile
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
		$type = $attr_array['type']; //文件名
		//$id = $attr_array['id']; //文件名
		if( empty($type) ) return;
		
		switch($type)
		{
			case 'single':
				/*单页面 即后台的公司资料*/
				$compile_content = "<?php require_once(WEB_CLASS . \"/class.single.php\");\r\n";
				$compile_content .= "\$cls_single = new cls_single();\r\n";		
				if( isset($attr_array['id']) )
				{
					$classid = $attr_array['id'];
					$compile_content .= "\r\n\$id = {$id};";
				} else
				{
					$compile_content .= "\r\nglobal \$id;";
				}
				$compile_content .= "\$dcr_single_data_info = \$cls_single->get_info(\$id); ?>";
				break;
			case 'product':
				/*产品页*/
				$compile_content = "<?php \$cls_product = cls_app::get_product();\r\n";
				if( isset($attr_array['id']) )
				{
					$id = $attr_array['id'];
					$compile_content .= "\r\n\$id = {$id};";
				} else
				{
					$compile_content .= "\r\nglobal \$id;";
				}
				$compile_content .="\$dcr_product_data_info = \$cls_product->get_info(\$id);\r\n\$dcr_product_data_info['classname'] = \$cls_product->get_class_name(\$dcr_product_data_info['classid']); ?>";
				break;
			case 'news':
				/*产品页*/
				$compile_content = "<?php \r\n\$cls_news = cls_app::get_news();\r\n";
				if( isset($attr_array['id']) )
				{
					$classid = $attr_array['id'];
					$compile_content .= "\r\n\$id = {$id};";
				} else
				{
					$compile_content .= "\r\nglobal \$id;";
				}
				$compile_content .= "\$cls_news-> update_click(\$id);\r\n\$dcr_news_data_info = \$cls_news->get_info(\$id); ?>";
				break;
			default:
				break;
		}
		
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