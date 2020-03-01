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
use mysql_xdevapi\Exception;

class ENV
{
    static $path = ROOT_APP . DS . '..' . DS . 'env';

    static function init()
    {
        $envPath = self::$path;
        if ( ! file_exists($envPath)) {
            //use the example
            $envPath = ROOT_APP . DS . '..' . DS . 'env.example';
        }
        if (file_exists($envPath)) {
            $autodetect = ini_get('auto_detect_line_endings');
            ini_set('auto_detect_line_endings', '1');
            $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            ini_set('auto_detect_line_endings', $autodetect);

            var_dump( $envPath );
            var_dump(file_get_contents($envPath));
            dd($envLines);
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
    static function getData($envPath = '')
    {
        $envPath = $envPath ? $envPath : self::$path;
        if (file_exists($envPath)) {
            $iniReader = new IniReader();
            return $iniReader->readFile($envPath);
        } else {
            throw new \Exception($envPath . ' file does not exists');
        }
    }

    static function write($envFile, $data)
    {
        if (file_exists($envFile)) {
            $iniWriter = new IniWriter();
            $iniWriter->writeToFile($envFile, $data);
        } else {
            throw new \Exception($envFile . ' can not writed or not exists');
        }
    }
}