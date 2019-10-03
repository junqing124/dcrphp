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

class cls_template_menu extends cls_template implements interface_tag_compile
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
		
		//得出第一行内容即{dcr:list table='test'}这行的内容
		$block_first_line = parent:: get_block_first_line($tag_info);
		
		$sql_option = "<?php \r\n \trequire_once(WEB_CLASS . \"/class.menu.php\");";
		$sql_option .= "\r\n \t\$cls_menu = new cls_menu();";
		$sql_option .= "\r\n \t\$dcr_menu_list = \$cls_menu->get_list();";
		$sql_option .= "\r\n\tforeach(\$dcr_menu_list as \$dcr_data_info)\r\n\t{";
		$sql_option .= "\r\n?>";		
		
		//去掉头和尾的标签
		$compile_content = str_replace( $block_first_line, $sql_option, $compile_content );
		$this->compile_content = str_replace('{/dcr:' . $tag_info['tag_name'] . '}', "<?php \r\n\t}\r\n\tunset(\$dcr_data_info, \$dcr_menu_list); \r\n?>", $compile_content);
		//cls_app:: log($this->compile_content);
		$this->compile_content = $this->compile_block_inner_tag();
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
        $inner_tag = array();
		$compile_content = $this->compile_content;
        if(preg_match_all('/\{\$([_a-zA-Z1-9]+)}/U', $compile_content, $inner_tag))
        {
            for($i = 0; $i<count($inner_tag[0]); $i++)
            {
                $compile_content = str_replace($inner_tag[0][$i], "<?php echo \$dcr_data_info['" . $inner_tag[1][$i] . "']; ?>", $compile_content);
            }
        }

        
        //处理标签块里的标记子标记
        $child_tag = array(); //0=>标记内容 1=>标记类型 2=>标记名
        if(preg_match_all('/\{dcr\.field\.([_a-zA-Z1-9]+)}/U', $compile_content, $child_tag))
        {
            //p_r($child_tag);
            //exit;
            for($i = 0; $i<count($child_tag[0]); $i++)
            {
                $compile_content = str_replace($child_tag[0][$i], "<?php echo \$dcr_data_info['" . $child_tag[1][$i] . "']; ?>", $compile_content);
            }
        }
		
		return $compile_content;
	}
}

?>