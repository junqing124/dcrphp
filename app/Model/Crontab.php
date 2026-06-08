<?php

declare(strict_types=1);

namespace app\Model;

use dcr\App;
use dcr\DcrBase;
use dcr\facade\Db;

class Crontab extends DcrBase
{
    private $crontabName;
    private $processId;
    private $result;
    private $statusList = array('执行中', '执行成功', '执行失败'); //任务的三个状态
    private $timeStart;

    public function __construct($processId, $crontabName)
    {
        $this->processId = $processId;
        $this->crontabName = $crontabName;
        $this->crontabName = self::crontabNameToClassName($this->crontabName);
        $this->check();
    }

    private function getClassName()
    {
        return "app\\Crontab\\" . $this->crontabName;
    }

    public function check()
    {
        $className = $this->getClassName($this->crontabName);
        if (!class_exists($className)) {
            throw new \Exception('类不存在，请添加');
        }
    }

    public function recordStart()
    {
        $time = microtime(true);
        $this->timeStart = $time;
        return DB::insert(
            'crontab',
            array(
                'name' => $this->crontabName,
                'process_id' => $this->processId,
                'time_start' => $time,
                'status' => '执行中',
            )
        );
    }

    public function recordEnd($msg = '')
    {
        $time = microtime(true);
        $info = array(
            'time_end' => $time,
            'time_spend' => round($time - $this->timeStart, 4),
        );
        if ($this->result['ack']) {
            $info['status'] = '执行成功';
        } else {
            $info['status'] = '执行失败';
            $info['msg'] = $msg ? $msg : json_encode($this->result['msg']);
            $info['msg'] = $info['msg'];
        }
        return DB::update('crontab', $info, "name='{$this->crontabName}' and process_id='{$this->processId}'");
    }

    public function handler()
    {
        $className = $this->getClassName($this->crontabName);
        $cls = new $className();
        $this->result = $cls->handler();
    }

    /**
     * 把名字格式化成类名 class->Class class_name->ClassName
     * @param string $crontabName
     * @return string
     */
    public static function crontabNameToClassName($crontabName = '')
    {
        $crontabName = APP::formatParam($crontabName, '_');
        return ucfirst($crontabName);
    }

    public static function getClassPath($crontabName = '')
    {
        $crontabName = self::crontabNameToClassName($crontabName);
        return ROOT_APP . DS . 'Crontab' . DS . "{$crontabName}.php";
    }
}
