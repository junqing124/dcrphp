<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 12:43
 */

namespace dcr;


class ENV
{
    static function init()
    {
        $envPath = ROOT_APP . DS . '..' . DS . 'env';
        if (file_exists($envPath)) {
            $autodetect = ini_get('auto_detect_line_endings');
            ini_set('auto_detect_line_endings', '1');
            $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            ini_set('auto_detect_line_endings', $autodetect);

            foreach ($envLines as $envConfig) {
                putenv(trim($envConfig));
            }
        }
    }
}