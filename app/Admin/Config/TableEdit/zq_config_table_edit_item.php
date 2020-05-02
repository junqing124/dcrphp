<?php
use app\Admin\Model\Common;

$supportDataType = Common::getFieldTypeList();
$supportDataType = array_column($supportDataType, 'key');
if (!in_array($dbInfo['ctei_data_type'], $supportDataType) && empty($dbInfo['ctei_default'])) {
    throw new \Exception('数据类型不在允许范围内，只允许' . implode(',', $supportDataType));
}

//如果type是radio或者checkbox或者select没有default则报错
if (in_array($dbInfo['ctei_data_type'],
        array('checkbox', 'radio', 'select')) && empty($dbInfo['ctei_default'])) {
    throw new \Exception('checkbox,radio,select类型的数据，请输入默认值');
}