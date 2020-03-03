<?php

namespace dcr;

use mysql_xdevapi\Exception;

class Console extends DcrBase
{
    /**
     * console:name to consoleName
     * @param $consoleName
     * @return string
     */
    public function consoleNameToClassName($consoleName)
    {
        $command = $consoleName;
        $commandArr = explode(':', $command);
        if (2 != count($commandArr)) {
            throw new Exception('error input parameters, format must bu like console:name');
            exit;
        }

        $commandList = [];
        foreach ($commandArr as $key => $commandStr) {
            $commandList[$key] = ucfirst($commandStr);
        }
        $className = implode('', $commandList);
        return $className;
    }

    /**
     * @param $className
     * @return string
     */
    public function getConsoleClassPath($className)
    {
        return ROOT_APP . DS . 'Console' . DS . "{$className}.php";
    }
}
