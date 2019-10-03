<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 类处理接口，每个模板标记处理类都要interface这个接口^_^
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0.１
 * @package class
 * @update 20130806
 * @since 1.0.9
*/

interface interface_tag_compile
{
	/**
	 * 编译tag
	 * @return string
	 */
	function compile_tag();	
	
	/**
	 * 获取编译后的内容
	 * @return string
	 */
	function get_content();
}

?>