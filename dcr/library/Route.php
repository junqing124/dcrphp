<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/4
 * Time: 0:56
 */

namespace dcr;

class Route extends DcrBase
{
    private $configDirList = [];

    /**
     * @var Rule类实例
     */
    private $rule;

    public function __construct()
    {
        $this->rule = container()->make('rule');
        //$this->loadConfig();
    }

    public function loadConfig()
    {
        $this->configDirList[] = ROOT_FRAME . DS . 'config' . DS . 'route' . DS;
        //dd($this->configDirList);
        //得出所有的配置文件列表
        foreach ($this->configDirList as $dir) {
            if (file_exists($dir)) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ('.' == $file || '..' == $file) {
                        continue;
                    }
                    $filePath = $dir . $file;
                    if (file_exists($filePath)) {
                        $this->configList = require_once $dir . $file;
                    }
                }
            }
        }
    }

    public function exec()
    {
    }

    public function addRuleFromRequest(Request $request)
    {
        $path = $request->getPath();
        if (empty($path) || '/' == $path) {
            $path = 'Index/Index/index';
        }

        $pathList = explode('/', $path);

        //添加规则给rule
        $ruleItem = container()->make('rule_item');

        $ruleItem->type = 'model';
        $ruleItem->model = $pathList[0];
        $ruleItem->controller = $pathList[1];
        $ruleItem->action = $pathList[2];
        unset($pathList[0], $pathList[1], $pathList[2]);
        $ruleItem->params = $pathList;

        //dd($_REQUEST);
        $request->setParams($pathList);

        $this->rule->addRuleItem($ruleItem);

        return $ruleItem;
    }
}
