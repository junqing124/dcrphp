<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 12:43
 */

namespace dcr;

use Matomo\Ini\IniReader;
use Matomo\Ini\IniWriter;

class ENV
{
    public static $path = ROOT_APP . DS . '..' . DS . 'env';

    public static function init()
    {
        $envPath = self::$path;
        if (!file_exists($envPath)) {
            //use the example
            $envPath = ROOT_APP . DS . '..' . DS . 'env.example';
        }
        if (file_exists($envPath)) {
            $autodetect = ini_get('auto_detect_line_endings');
            ini_set('auto_detect_line_endings', '1');
            $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            ini_set('auto_detect_line_endings', $autodetect);

            foreach ($envLines as $envConfig) {
                $envConfig = str_replace('"', '', $envConfig);
                $envConfig = str_replace(' = ', '=', $envConfig);
                putenv(trim($envConfig));
            }
        } else {
            throw new \Exception($envPath . ' file does not exists');
        }
    }

    /**
     * parse ini get the data
     * @param $envPath
     * @return array
     * @throws
     */
    public static function getData($envPath = '')
    {
        $envPath = $envPath ? $envPath : self::$path;
        if (file_exists($envPath)) {
            $iniReader = new IniReader();
            return $iniReader->readFile($envPath);
        } else {
            throw new \Exception($envPath . ' file does not exists');
        }
    }

    public static function write($envFile, $data)
    {
        if (!file_exists($envFile)) {
            file_put_contents($envFile, '');
        } else {
            throw new \Exception($envFile . ' can not be created');
        }
        if (file_exists($envFile)) {
            $iniWriter = new IniWriter();
            $iniWriter->writeToFile($envFile, $data);
        } else {
            throw new \Exception($envFile . ' can not writed');
        }
    }
}
