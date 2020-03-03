<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/29
 * Time: 0:22
 */

namespace dcr;

class Config extends DcrBase
{
    /**
     * @var array 配置
     */
    private $config = [];

    /**
     * 配置目录
     */
    private $configDirList = [];

    /**
     * @param $dirName 设置或添加配置目录名
     */
    public function setConfigDirList($dirName)
    {
        array_push($this->configDirList, $dirName);
    }

    public function load($filename, $type)
    {
        $configType = pathinfo($filename, PATHINFO_FILENAME);
        $driverName = ucfirst($type);
        $className = "dcr\config\driver\\{$driverName}";
        container()->bind('configDriver', $className);
        $configDetail = container()->make($className)->parse($filename);
        $this->set($configType, $configDetail);
    }

    public function get($name = '')
    {
        if (empty($name)) {
            return $this->config;
        }

        //返回配置
        $configSplit = explode('.', $name);
        if (count($configSplit) < 2) {
            // app
            return $this->config[$name];
        }
        if (empty($configSplit[1])) {
            // app.
            return $this->config[$configSplit[0]];
        }

        //database.mysql.main.driver
        $value = "";
        foreach ($configSplit as $configName) {
            if (empty($configName)) {
                break;
            }
            if (empty($value)) {
                $value = $this->config[$configName];
                if (empty($value)) {
                    //防止死循环
                    $value = 'not config';
                    break;
                }
            } else {
                $value = $value[$configName];
            }
        }
        return $value == 'not config' ? '' : $value;
    }

    public function set($configType, $config)
    {
        $this->config[$configType] = $config;
        //dd($this);
    }

    public function loadConfig()
    {
        $this->setConfigDirList(CONFIG_DIR);
        //得出所有的配置文件列表
        foreach ($this->configDirList as $dir) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ('.' . pathinfo($file, PATHINFO_EXTENSION) === CONFIG_EXT) {
                    $filename = $dir . DS . $file;
                    $this->load($filename, pathinfo($file, PATHINFO_EXTENSION));
                }
            }
        }
    }
}
