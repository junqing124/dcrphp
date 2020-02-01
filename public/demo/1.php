<?php
$datasection = array(



    array('id' => 1, 'name' => '安徽', 'pid' => 0),

    array('id' => 2, 'name' => '北京', 'pid' => 0),

    array('id' => 3, 'name' => '海淀', 'pid' => 2),

    array('id' => 4, 'name' => '中关村', 'pid' => 3),

    array('id' => 5, 'name' => '合肥', 'pid' => 1),

    array('id' => 6, 'name' => '上地', 'pid' => 3),

    array('id' => 7, 'name' => '河北', 'pid' => 0),

    array('id' => 8, 'name' => '石家庄', 'pid' => 7),



);



function getTree($data, $pId)

{

    $tree = '';

    foreach($data as $k => $v)

    {

        if($v['pid'] == $pId)

        {

            $v['pid'] = getTree($data, $v['id']);

            $tree[] = $v;

            unset($data[$k]);

        }

    }

    return $tree;

}



$tree = getTree($datasection, 0);
echo '<pre>';
print_r($tree);