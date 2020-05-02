<?php


namespace app\Admin\Model;


use dcr\Db;

class Tools
{
    public function getTableEditPhpAddition($key)
    {
        $path = ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'TableEdit' . DS . $key . '.php';
        return $path;
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
                'table' => 'zq_config_table_edit_list',
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
                'table' => 'zq_config_table_edit_list',
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
                'table' => 'zq_config_table_edit_item',
                'where' => "ctel_id={$info['id']}",
            )
        );
        $fieldKeys = array_column($fieldList, 'db_field_name');
        $fieldList = array_combine($fieldKeys, $fieldList);

        $config['col'] = $fieldList;

        return $config;
    }
}