<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/29
 * Time: 0:04
 */

namespace dcr;

class Page
{
    private $url;
    private $cpage;
    private $tatolPage;
    private $tpl;
    private $webUrlModule;

    /**
     * 构造函数
     * 模板说明：{index}表示首页 {pagelist}链接列表 {option}下拉列表框 {next}下一页 {pre}上一页 {cur}当前页 {index=首页}表示首页的链接文字为首页，即=号后为链接文字，不过这对{pagelist}{option}无效
     * @param int $cpage 当前页
     * @param int $totalPage 总页数
     * @param string $tpl 模板.
     * @param string $url 要分页的url 默认为当前页
     * @return mixed
     */
    public function __construct($cpage, $totalPage, $tpl = '', $url = '')
    {
        $this->cpage = $cpage;
        $this->tatolPage = $totalPage;
        if (strlen($tpl) == 0) {
            $this->tpl = "{cur=当前页} {index=首页} {pre=上一页} {next=下一页} {end=最后页} {option}"; //中文分页
        } else {
            $this->tpl = $tpl;
        }
        if (strlen($url) == 0) {
            $this->url = $_SERVER['HTTP_HOST'];
            //if ($_SERVER['SERVER_PORT']) {
            //$this->url .= ':' . $_SERVER['SERVER_PORT'];
            //}
            $this->url .= $_SERVER["REQUEST_URI"];
        } else {
            $this->url = $url;
        }
        $this->webUrlModule = '1';
    }

    /**
     * 返回生成的分页HTML
     * @return string
     */
    public function showPage()
    {
        //显示分页
        $urlOptionStr = '';
        $urlOptionStrT = '';
        $newUrl = '';
        $urlOption = array();//url的后缀如：?page=1&typeid=1
        /*echo $this->url;
        echo '<br>';
        exit;*/
        $parseUrl = parse_url($this->url);
        $urlMain = 'http://' . $parseUrl['host'];
        //dd($parseUrl);
        if ($parseUrl['port']) {
            $urlMain .= ':' . $parseUrl['port'];
        }
        $urlMain .= $parseUrl['path'];
        if ($parseUrl['query']) {
            //url有参数
            $url_arr = preg_split('/&/', $parseUrl['query']);
            if (is_array($url_arr)) {
                foreach ($url_arr as $key => $value) {
                    $c = preg_split('/=/', $value);
                    if ($c[0] == 'page') {
                    } else {
                        array_push($urlOption, $c[0] . '=' . $c[1]);
                    }
                }
            }
        } else {
        }

        if (is_array($urlOption)) {
            $urlOptionStrT = implode('&', $urlOption);
        }
        if (strlen($urlOptionStrT) > 0) {
            $urlOptionStr .= '&' . $urlOptionStrT;
        }
        /*echo $urlMain;
        echo '<br>';
        echo $urlOptionStr;*/

        $tplContent = $this->tpl;//分页模板
        $page_html = $tplContent;

        //首页
        if (preg_match_all('/\{index=([^}]*+)\}/', $tplContent, $matches)) {
            if ($this->webUrlModule == '1') {
                $newUrl = '';
                $newUrl = $urlMain . '?page=1' . $urlOptionStr;
            } else {
                if ($this->webUrlModule == '2') {
                    $newUrl = '';
                    $t_arr = array();
                    $t_file_arr = array();
                    $urlMain = preg_replace('/_p_(\d+)/', '', $urlMain);
                    $t_arr = parse_url($urlMain);
                    $t_file_arr = explode('.', $t_arr['path']);
                    $newUrl = $t_arr[0] . $t_file_arr[0] . '_p_1.' . $t_file_arr[1];
                }
            }
            $t_tpl = $matches[0][0]; //模板内容
            $t_word = $matches[1][0]; //分页字段
            $index_str = '<a href="' . $newUrl . '">' . $t_word . '</a>';
            $page_html = str_replace($t_tpl, $index_str, $page_html);
        }

        //当前页
        if (preg_match_all('/\{cur=([^}]*+)\}/', $tplContent, $matches)) {
            $t_tpl = $matches[0][0];
            $t_word = $matches[1][0];
            $cur_str = $t_word . $this->cpage . '/' . $this->tatolPage;
            $page_html = str_replace($t_tpl, $cur_str, $page_html);
        }

        //末页
        if (preg_match_all('/\{end=([^}]*+)\}/', $tplContent, $matches)) {
            //这里判断 如果总页数为0 则最后页设置为1
            $tatolPage = $this->tatolPage == 0 ? 1 : $this->tatolPage;
            if ($this->webUrlModule == '1') {
                $newUrl = '';
                $newUrl = $urlMain . '?page=' . $tatolPage . $urlOptionStr;
            } else {
                if ($this->webUrlModule == '2') {
                    $newUrl = '';
                    $t_arr = array();
                    $t_file_arr = array();
                    $urlMain = preg_replace('/_p_(\d+)/', '', $urlMain);
                    $t_arr = parse_url($urlMain);
                    $t_file_arr = explode('.', $t_arr['path']);
                    $newUrl = $t_arr[0] . $t_file_arr[0] . '_p_' . $tatolPage . '.' . $t_file_arr[1];
                }
            }
            $t_tpl = $matches[0][0];
            $t_word = $matches[1][0];
            $end_page = '<a href="' . $newUrl . '">' . $t_word . '</a>';
            $page_html = str_replace($t_tpl, $end_page, $page_html);
        }

        //上一页
        if (preg_match_all('/\{pre=([^}]*+)\}/', $tplContent, $matches)) {
            $t_tpl = $matches[0][0];
            $t_word = $matches[1][0];
            if ($this->cpage != 1) {
                if ($this->webUrlModule == '1') {
                    $newUrl = '';
                    $newUrl = $urlMain . '?page=' . ($this->cpage - 1) . $urlOptionStr;
                } elseif ($this->webUrlModule == '2') {
                    $newUrl = '';
                    $t_arr = array();
                    $t_file_arr = array();
                    $urlMain = preg_replace('/_p_(\d+)/', '', $urlMain);
                    $t_arr = parse_url($urlMain);
                    $t_file_arr = explode('.', $t_arr['path']);
                    $newUrl = $t_arr[0] . $t_file_arr[0] . '_p_' . ($this->cpage - 1) . '.' . $t_file_arr[1];
                }
                $pre_page = '<a href="' . $newUrl . '">' . $t_word . '</a>';
            } else {
                $pre_page = $t_word;
            }
            $page_html = str_replace($t_tpl, $pre_page, $page_html);
        }

        //下一页
        if (preg_match_all('/\{next=([^}]*+)\}/', $tplContent, $matches)) {
            $t_tpl = $matches[0][0];
            $t_word = $matches[1][0];
            if ($this->cpage != $this->tatolPage && $this->tatolPage > 1) {
                //var_dump($this->webUrlModule);
                if ($this->webUrlModule == '1') {
                    //echo 'a';
                    $newUrl = '';
                    $newUrl = $urlMain . '?page=' . ($this->cpage + 1) . $urlOptionStr;
                } else {
                    if ($this->webUrlModule == '2') {
                        //echo 'b';
                        $newUrl = '';
                        $t_arr = array();
                        $t_file_arr = array();
                        $urlMain = preg_replace('/_p_(\d+)/', '', $urlMain);
                        $t_arr = parse_url($urlMain);
                        $t_file_arr = explode('.', $t_arr['path']);
                        $newUrl = $t_arr[0] . $t_file_arr[0] . '_p_' . ($this->cpage + 1) . '.' . $t_file_arr[1];
                    }
                }
                $next_page = ' <a href="' . $newUrl . '">' . $t_word . '</a>';
            } else {
                $next_page = $t_word;
            }
            $page_html = str_replace($t_tpl, $next_page, $page_html);
        }

        //链接列表
        if (preg_match("{pagelist}", $tplContent)) {
            $start = 1;
            $end = $this->tatolPage;
            if ($this->webUrlModule == '1') {
                if ($this->tatolPage > 10) {
                    if ($this->cpage > 5) {
                        //echo $this->tatolPage;
                        if ($this->cpage + 10 > $end) {
                            $start = $this->cpage - (10 - ($this->tatolPage - $this->cpage));
                            $end = $end;
                        } else {
                            $start = $this->cpage - 5;
                            $end = $start + 10;
                        }
                        //$start = ( $start + 10 > $end ) ? ( $this->cpage - ( 10 - ($this->tatolPage - $this->cpage) ) ) : $this->cpage - 5;
                        //echo $start;
                        //$end = ( $start + 10 > $end ) ? $end : $start + 10;
                        //echo $end;
                    } else {
                        $start = 1;
                        $end = 11;
                    }
                }/*else
                {
                    $start = 1;
                    $end = $this->tatolPage;
                }*/
                for ($j = $start; $j <= $end; $j++) {
                    $page_list_url = $urlMain . '?page=' . $j . $urlOptionStr;
                    if ($j == $this->cpage) {
                        $link_page .= ' <a class="current" href="' . $page_list_url . '">' . $j . '</a>';
                    } else {
                        $link_page .= ' <a href="' . $page_list_url . '">' . $j . '</a>';
                    }
                }
            } else {
                if ($this->webUrlModule == '2') {
                    $newUrl = '';
                    $t_arr = array();
                    $t_file_arr = array();
                    $urlMain = preg_replace('/_p_(\d+)/', '', $urlMain);
                    $t_arr = parse_url($urlMain);
                    $t_file_arr = explode('.', $t_arr['path']);
                    $newUrl = $t_arr[0] . $t_file_arr[0] . '_p_' . $i . '.' . $t_file_arr[1];
                    $link_page .= ' <a href="' . $newUrl . '">' . $i . '</a>';
                }
            }
            $page_html = str_replace('{pagelist}', $link_page, $page_html);
        }

        //下拉框分页
        if (preg_match("{option}", $tplContent)) {
            $option_page = '<select onchange="javascript:window.location=' . "'" . $urlMain . "?page='+this.options[this.selectedIndex].value+" . "'$urlOptionStr'" . ';">';
            for ($i = 1; $i < $this->tatolPage + 1; $i++) {
                if ($i == $this->cpage) {
                    $option_page .= "<option selected='selected' value='$i'>第" . $i . "页</option>\n";
                } else {
                    $option_page .= "<option value='$i'>第" . $i . "页</option>\n";
                }
            }
            $option_page .= '</select>';
            $page_html = str_replace('{option}', $option_page, $page_html);
        }

        return $page_html;
    }
}
