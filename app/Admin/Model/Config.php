<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use app\Admin\Model\Common;
use dcr\Db;

class Config
{

    /**
     * 通过数据库字段名获取配置内容
     * @param $db_field_name 配置的键名
     */
    public function getConfigByDbFieldName($db_field_name)
    {
        $info = Db::select(
            array(
                'table' => 'config',
                'where' => "db_field_name='{$db_field_name}'",
                'limit' => 1,
                'col'=>'value',
            )
        );
        $info = current($info);
        return $info['value'];
    }
    /**
     * 更新配置
     * @param $configList
     * @param $list_id config list id
     * @return array
     */
    public function config($configList, $list_id)
    {
        $configItemList = $this->getConfigListItemByListId($list_id);
        $configItemList = array_column($configItemList, 'db_field_name');

        foreach ($configList as $db_field_name => $value) {
            //没在配置中的退出
            if (! in_array($db_field_name, $configItemList)) {
                continue;
            }
            $valueStr = is_array($value) ? implode(',', $value) : $value;
            $dbInfo = array(
                'add_user_id' => session('userId'),
                'zt_id' => session('ztId'),
                'db_field_name' => $db_field_name,
                'value' => $valueStr,
                'cl_id' => $list_id,
            );
            //判断
            $info = Db::select(
                array(
                    'table' => 'config',
                    'where' => "db_field_name='{$db_field_name}' and cl_id={$list_id}",
                    'limit' => 1,
                    'col'=>'id',
                )
            );
            $info = current($info);
            //处理
            if ($info) {
                $result = DB::update('config', $dbInfo, "id={$info['id']}");
            } else {
                $result = DB::insert('config', $dbInfo);
            }
            //var_dump( $result );
        }
        //返回
        return Admin::commonReturn(1);
    }

    public function configListEdit($configListName, $type = 'add', $id = 0, $clType = 'config', $configListKey)
    {
        $dbInfo = array(
            'add_user_id' => session('userId'),
            'zt_id' => session('ztId'),
            'name' => $configListName,
            'type' => $clType,
            'keyword' => $configListKey
        );

        if (empty($configListName)) {
            throw new \Exception('请填写名称');
        }

        //处理
        if ('add' != $type) {
            $result = DB::update('config_list', $dbInfo, "id='{$id}'");
        } else {
            $dbInfo['is_system'] = 0;
            $result = DB::insert('config_list', $dbInfo);
            //var_dump($result);
        }
        /*dd(get_defined_vars());
        dd( $dbInfo );*/
        //返回
        return Admin::commonReturn($result);
    }

    public function getConfigList($id = 0, $type = '', $key = '')
    {
        $whereArr = array();
        if ($id) {
            $whereArr[] = "id={$id}";
        }
        if( $type ){
            $whereArr[] = "type='{$type}'";
        }
        if( $key ){
            $whereArr[] = "keyword='{$key}'";
        }
        $list = DB::select(array(
            'table' => 'config_list',
            'col' => 'id,name,is_system,add_time,keyword',
            'where' => $whereArr,
        ));
        return $list;
    }

    public function getConfigListItemList($whereArr)
    {
        $list = Db::select(array(
            'table' => 'config_list_item',
            'col' => 'id,add_time,form_text,data_type,db_field_name,order_str,is_system,default_str',
            'where' => $whereArr,
            'order' => 'order_str asc',
        ));
        return $list;
    }

    public function getConfigValueList($listId)
    {
        $whereArr = array("cl_id={$listId}");
        $list = Db::select(array(
            'table' => 'config',
            'col' => 'db_field_name,value',
            'where' => $whereArr,
        ));
        return $list;
    }

    public function getConfigListItemByListId($listId)
    {
        $whereArr = array();
        $whereArr[] = "cl_id={$listId}";
        return $this->getConfigListItemList($whereArr);
    }

    public function getConfigListItem($id)
    {
        $whereArr = array();
        $whereArr[] = "id={$id}";
        return $this->getConfigListItemList($whereArr);
    }

    /**
     * 从1.0.3作废
     * 获取全部或某模块的配置列表
     * @param string $modelName
     * @return array
     */
    public function getConfigModelListAbandon($modelName = '')
    {
        //var_dump('a');
        $ztId = session('ztId');
        $where = array();
        $where[] = "zt_id={$ztId}";
        if ($modelName) {
            array_push($where, "cm_model_name='{$modelName}'");
        }
        $list = DB::select(array(
            'col' => 'cm_key,cm_dec,cm_model_name,cm_id',
            'where' => $where,
            'table' => 'config_model'
        ));
        $result = array();
        if ($list) {
            foreach ($list as $info) {
                if (!$result[$info['cm_model_name']]) {
                    $result[$info['cm_model_name']] = array();
                }
                array_push($result[$info['cm_model_name']], $info);
            }
        }
        return $result;
    }

    /**
     * 从1.0.3开始起，作废
     * @param $modelInfo
     * 本参数为model配置传送过来，可能无法接收独立的参数info过来
     * @return array
     */
    public function configModelAbandon($modelInfo)
    {
        //判断
        //先判断key有没有重复
        $defineList = Common::getModelDefine();
        $isError = 0;
        $errorMsg = array();
        foreach ($defineList as $defineName => $defineInfo) {
            $keyList = $modelInfo["key_{$defineName}"];
            if ($keyList) {
                if (count($keyList) != count(array_unique(array_values($keyList)))) {
                    $isError = 1;
                    $errorMsg[] = $defineInfo['dec'] . '-关键字重复了';
                }
            }
        }
        if ($isError) {
            return Admin::commonReturn(0, implode(',', $errorMsg));
        }
        //处理
        $userId = session('userId');
        $ztId = session('ztId');
        //dd( $modelInfo['key_product'] );
        foreach ($defineList as $defineName => $defineInfo) {
            $keyList = $modelInfo["key_{$defineName}"];
            $decList = $modelInfo["dec_{$defineName}"];
            /*dd("key_{$defineName}");
            dd("dec_{$defineName}");
            dd( $keyList );
            dd( $decList );*/
            if (!$keyList) {
                continue;
            }
            foreach ($keyList as $key => $keyName) {
                $dbInfo = array(
                    'add_user_id' => $userId,
                    'zt_id' => $ztId,
                    'cm_key' => $keyName,
                    'cm_dec' => $decList[$key],
                    'cm_model_name' => $defineName,
                );
                if (empty($dbInfo['cm_key'])) {
                    continue;
                }
                $sql = "select cm_id from config_model where cm_key='{$dbInfo['cm_key']}' and cm_model_name='{$dbInfo['cm_model_name']}' and zt_id={$dbInfo['zt_id']}";
                $info = DB::query($sql);
                //处理
                if ($info) {
                    $info = current($info);
                    DB::update('config_model', $dbInfo, "cm_id={$info['cm_id']}");
                } else {
                    DB::insert('config_model', $dbInfo);
                }
            }
        }

        //要删除的
        $delIds = $modelInfo['del'];
        if ($delIds) {
            $delIdList = explode('_', $delIds);
            $delIdList = array_filter($delIdList);
            $delIdStr = implode(',', $delIdList);
            DB::delete('config_model', "cm_id in($delIdStr)");
        }
        //返回
        return Admin::commonReturn(1);
    }

    public function getSystemTemplate()
    {
        $templateDir = ROOT_PUBLIC . DS . 'resource' . DS . 'template';
        $dirList = scandir($templateDir);
        foreach ($dirList as $key => $dirName) {
            if (in_array($dirName, array('..', '.'))) {
                unset($dirList[$key]);
            }
        }
        return $dirList;
    }

    public function configListDelete($id)
    {
        //验证
        $info = DB::select(array(
            'table' => 'config_list',
            'col' => 'id,is_system',
            'where' => "id={$id}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            throw new \Exception('没有找到这个信息');
        }
        if ($info['is_system']) {
            throw new \Exception('系统自带的配置项无法删除');
        }
        //逻辑
        $result = DB::delete('config_list', "id={$id}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    /**
     * @param $data 添加 编辑 或删除 的数据
     * @param $type insert update delete(如果是delete 请设置data['id])
     * @return array
     * @throws \Exception
     */
    public function configListItem($data, $type)
    {
        $dbInfo = array(
            'form_text' => $data['form_text'],
            'data_type' => $data['data_type'],
            'db_field_name' => $data['db_field_name'],
            'default_str' => $data['default_str'],
            'order_str' => intval($data['order_str']),
            'cl_id' => $data['addition_id'],
        );
        //检测
        $check = array(
            'form_text' => array('type' => 'required'),
            'data_type' => array('type' => 'required'),
            'db_field_name' => array('type' => 'required'),
            'order_str' => array('type' => 'number'),
        );
        return Common::CUDDbInfo(
            'config_list_item',
            'cli',
            $dbInfo,
            $actionType = $type,
            $option = array('id' => $data['id'], 'check' => $check)
        );
    }
}
