<?php


namespace app\Admin\Model;


use dcr\Db;

class Tools
{
    public function getTableEditEditAddition($key)
    {
        $path = ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'TableEdit' . DS . $key . DS . 'edit.php';
        return $path;
    }

    public function getTableEditDeleteAddition($key)
    {
        $path = ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'TableEdit' . DS . $key . DS . 'delete.php';
        return $path;
    }

    /**
     * 生成TableEdit时，默认显示的字段
     * @return string[]
     */
    public function getDefaultFieldConfig()
    {
        $config = array(
            'list' => array('id', 'add_time', 'name', 'title'),
            'search' => array('name', 'title'),
            'search_type' => 'like', //如果是搜索，则默认这个
        );
        return $config;
    }

    /**
     * 把html中的代码实别出来，替换成实际的变量 比如get.a换成get('a')
     * @param $html html代码
     */
    public function generateAdditionHtml($html)
    {
        if (preg_match_all('/\{((get)|(post))\.([\w\W]*)\}/U', $html, $result)) {
            foreach ($result[0] as $key => $item) {
                $functionName = $result[1][$key];
                $itemKey = $result[4][$key];
                $html = str_replace($item, $functionName($itemKey), $html);
            }
        }
        return $html;
    }

    /**
     * 通过ID获取TableEdit的key
     * @param $id
     */
    public function getTableEditKeyById($id)
    {
        $info = Db::select(
            array(
                'table' => 'config_table_edit_list',
                'where' => "id='{$id}'",
                'limit' => 1,
                'col' => 'keyword',
            )
        );
        if (empty($info)) {
            throw new \Exception('没有找到本配置');
        }
        $info = current($info);
        return $info['keyword'];
    }

    /**
     * 通过关键字获取单表配置
     * @param $key
     * @return array
     * @throws \Exception
     */
    public function getTableEditConfig($key)
    {
        if (empty($key)) {
            throw new \Exception('请输入配置表的关键字');
        }
        $info = Db::select(
            array(
                'table' => 'config_table_edit_list',
                'where' => "keyword='{$key}'",
                'limit' => 1,
            )
        );
        if (empty($info)) {
            throw new \Exception('没有找到本配置');
        }
        $info = current($info);
        $config = array();
        $keys = array_keys($info);
        foreach ($keys as $key) {
            $keyNew = str_replace('', '', $key);
            $config[$keyNew] = $info[$key];
        }
        //得出字段配置

        $fieldList = Db::select(
            array(
                'table' => 'config_table_edit_item',
                'where' => "ctel_id={$info['id']}",
            )
        );
        $fieldKeys = array_column($fieldList, 'db_field_name');
        $fieldList = array_combine($fieldKeys, $fieldList);

        $config['col'] = $fieldList;

        return $config;
    }

    /**
     * 通过表名生成单表管理
     * @param $keyword
     * @param $table_name
     * @param $page_title
     */
    public function tableEditGenerate($pageModel, $keyword, $tableName, $pageTitle)
    {
        $dbInfoMain = array();
        $dbInfoMain['page_title'] = $pageTitle;
        $dbInfoMain['keyword'] = $keyword;
        $dbInfoMain['table_name'] = $tableName;
        $dbInfoMain['page_model'] = $pageModel;
        $dbInfoMain['edit_window_width'] = '70%';
        $dbInfoMain['edit_window_height'] = '70%';
        $dbInfoMain['zt_id'] = 1;
        $dbInfoMain['add_user_id'] = session('userId');

        $id = Db::insert('config_table_edit_list', $dbInfoMain);
        //$id = 7;
        //开始子字段表
        $sql = "show full columns FROM {$tableName} /*zt_id*/;";
        $fieldList = Db::query($sql);
        $defaultConfig = $this->getDefaultFieldConfig();
        foreach ($fieldList as $fieldInfo) {
            $dbInfoSub = array();
            $fieldName = $fieldInfo['Field'];

            $dbInfoSub['is_show_list'] = in_array($fieldName, $defaultConfig['list']) ? 1 : 0;
            $dbInfoSub['is_search'] = in_array($fieldName, $defaultConfig['search']) ? 1 : 0;
            $dbInfoSub['search_type'] = in_array($fieldName,
                $defaultConfig['search']) ? $defaultConfig['search_type'] : '';
            $dbInfoSub['is_input_hidden'] = 0;
            $dbInfoSub['is_update_required'] = 0;
            $dbInfoSub['is_update'] = 0;
            $dbInfoSub['is_insert_required'] = 0;
            $dbInfoSub['is_insert'] = 0;
            //$fieldName['tip'] = $fieldInfo['Comment'];
            $dbInfoSub['data_type'] = substr($fieldName, 0, 3) == 'is_' ? 'checkbox' : 'string';
            $dbInfoSub['title'] = $fieldInfo['Comment'] ? $fieldInfo['Comment'] : $fieldName;
            $dbInfoSub['db_field_name'] = $fieldName;
            $dbInfoSub['ctel_id'] = $id;
            $dbInfoSub['zt_id'] = 1;

            Db::insert('config_table_edit_item', $dbInfoSub);
        }

        return Admin::commonReturn(1);
    }
}