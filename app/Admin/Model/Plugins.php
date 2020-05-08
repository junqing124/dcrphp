<?php


namespace app\Admin\Model;

use app\Admin\Model\Admin;
use dcr\Db;
use dcr\Request;

class Plugins
{
    private $pluginDir = ROOT_APP . DS . 'Admin' . DS . 'Plugins';

    public function getLocalPluginsList()
    {
        $listPlugins = array();
        $list = scandir($this->pluginDir);
        foreach ($list as $pluginName) {
            if (in_array($pluginName, array('.', '..'))) {
                continue;
            }
            $subDir = $this->pluginDir . DS . $pluginName;
            $configPath = $subDir . DS . 'Config.php';
            if (file_exists($configPath)) {
                $listPlugins[$pluginName] = include_once $configPath;
                $listPlugins[$pluginName]['source'] = 'local';
            }
        }

        return $listPlugins;
    }

    public function install($pluginName, $source)
    {
        //判断存在不存在
        $dir = $this->pluginDir . DS . $pluginName;
        $configPath = $dir . DS . 'Config.php';

        if (!file_exists($configPath)) {
            throw new \Exception('插件不存在');
        }

        //取信息
        $pluginInfo = include_once $configPath;

        $dbInfo = array();
        $dbInfo['name'] = $pluginInfo['name'];
        $dbInfo['description'] = $pluginInfo['description'];
        $dbInfo['author'] = $pluginInfo['author'];
        $dbInfo['version'] = $pluginInfo['version'];
        $dbInfo['title'] = $pluginInfo['title'];
        $dbInfo['zt_id'] = session('ztId');

        //判断存在不存在
        $info = DB::select(array(
            'table' => 'plugins',
            'col' => 'id',
            'where' => "name='{$dbInfo['name']}'",
            'limit' => 1
        ));
        $info = current($info);

        if ($info) {
            return Admin::commonReturn(0, '已经安装过了');
        }

        $result = DB::insert('plugins', $dbInfo);

        return Admin::commonReturn($result);
    }

    public function getInstalledList()
    {
        $list = DB::select(array(
            'table' => 'plugins',
        ));

        return $list;
    }

    public function getConfig($pluginName)
    {
        $subDir = $this->pluginDir . DS . $pluginName;
        $configPath = $subDir . DS . 'Config.php';
        if (!file_exists($configPath)) {
            throw new \Exception($pluginName . ':没有找到配置文件');
        }
        $config = include_once $configPath;

        return $config;
    }

    public function getControllerClass($pluginName)
    {

        return "\\app\\Admin\\Plugins\\{$pluginName}\\Controller\\{$pluginName}";
    }

    public function getPluginDir($pluginName)
    {
        return $this->pluginDir . DS . $pluginName;
    }
}
