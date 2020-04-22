<?php


namespace app\Admin\Model;


class Tools
{
    function getTableEditConfigPath($tableName)
    {
        return ROOT_APP . DS . 'Admin' .DS . 'Config' . DS . 'TableModel' . DS . $tableName . '.php';
    }
}