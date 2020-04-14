<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use app\Model\Common;
use dcr\Db;

class Config
{

    public function configBase($configList, $type = 'base')
    {
        foreach ($configList as $key => $value) {
            $dbInfo = array(
                'cb_update_time' => time(),
                'cb_add_user_id' => session('userId'),
                'zt_id' => session('ztId'),
                'cb_name' => $key,
                'cb_value' => $value,
                'cb_type' => $type,
            );
            //判断
            $sql = "select cb_id from zq_config_base where cb_name='{$dbInfo['cb_name']}' and zt_id={$dbInfo['zt_id']}";
            $info = DB::query($sql);
            //处理
            if ($info) {
                $info = current($info);
                $result = DB::update('zq_config_base', $dbInfo, "cb_id={$info['cb_id']}");
            } else {
                $dbInfo['cb_add_time'] = time();
                $result = DB::insert('zq_config_base', $dbInfo);
            }
            //var_dump( $result );
        }
        //返回
        return Admin::commonReturn(1);
    }

    public function configListEdit($configListName, $type = 'add', $id = 0)
    {
        $dbInfo = array(
            'cl_update_time' => time(),
            'cl_add_user_id' => session('userId'),
            'zt_id' => session('ztId'),
            'cl_name' => $configListName
        );

        if (empty($configListName)) {
            throw new \Exception('请填写名称');
        }

        //处理
        if ('add' != $type) {
            $result = DB::update('zq_config_list', $dbInfo, "cl_id='{$id}'");
        } else {
            $dbInfo['cl_add_time'] = time();
            $dbInfo['cl_is_system'] = 0;
            $result = DB::insert('zq_config_list', $dbInfo);
            //var_dump($result);
        }
        //var_dump( $result );
        //返回
        return Admin::commonReturn($result);
    }

    public function getConfigBaseList($type = 'base')
    {
        $whereArr = array();
        if ($type) {
            array_push($whereArr, "cb_type='{$type}'");
        }
        $list = DB::select(array(
            'table' => 'zq_config_base',
            'col' => 'cb_name,cb_value',
            'where' => $whereArr,
        ));
        return $list;
    }

    public function getConfigList($id = 0)
    {
        $whereArr = array();
        if ($id) {
            $whereArr[] = "cl_id={$id}";
        }
        $list = DB::select(array(
            'table' => 'zq_config_list',
            'col' => 'cl_id,cl_name,cl_is_system,cl_add_time',
            'where' => $whereArr,
        ));
        return $list;
    }

    public function getConfigListItemList($whereArr)
    {
        $list = DB::select(array(
            'table' => 'zq_config_list_item',
            'col' => 'cli_id,cli_add_time,cli_form_text,cli_data_type,cli_db_field_name,cli_order,cli_is_system,cli_default',
            'where' => $whereArr,
            'order' => 'cli_order asc',
        ));
        return $list;
    }

    public function getConfigListItemByListId($listId)
    {
        $whereArr = array();
        $whereArr[] = "cli_cl_id={$listId}";
        return $this->getConfigListItemList($whereArr);
    }

    public function getConfigListItem($id)
    {
        $whereArr = array();
        $whereArr[] = "cli_id={$id}";
        return $this->getConfigListItemList($whereArr);
    }

    /**
     * 获取全部或某模块的配置列表
     * @param string $modelName
     * @return array
     */
    public function getConfigModelList($modelName = '')
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
            'table' => 'zq_config_model'
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
     * @param $modelInfo
     * 本参数为model配置传送过来，可能无法接收独立的参数info过来
     * @return array
     */
    public function configModel($modelInfo)
    {
        //判断
        //先判断key有没有重复
        $defineList = Common::getModelCommon();
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
                    'cm_update_time' => time(),
                    'cm_add_user_id' => $userId,
                    'zt_id' => $ztId,
                    'cm_key' => $keyName,
                    'cm_dec' => $decList[$key],
                    'cm_model_name' => $defineName,
                );
                if (empty($dbInfo['cm_key'])) {
                    continue;
                }
                $sql = "select cm_id from zq_config_model where cm_key='{$dbInfo['cm_key']}' and cm_model_name='{$dbInfo['cm_model_name']}' and zt_id={$dbInfo['zt_id']}";
                $info = DB::query($sql);
                //处理
                if ($info) {
                    $info = current($info);
                    DB::update('zq_config_model', $dbInfo, "cm_id={$info['cm_id']}");
                } else {
                    $dbInfo['cm_add_time'] = time();
                    DB::insert('zq_config_model', $dbInfo);
                }
            }
        }

        //要删除的
        $delIds = $modelInfo['del'];
        if ($delIds) {
            $delIdList = explode('_', $delIds);
            $delIdList = array_filter($delIdList);
            $delIdStr = implode(',', $delIdList);
            DB::delete('zq_config_model', "cm_id in($delIdStr)");
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
            'table' => 'zq_config_list',
            'col' => 'cl_id,cl_is_system',
            'where' => "cl_id={$id}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            throw new \Exception('没有找到这个信息');
        }
        if ($info['cl_is_system']) {
            throw new \Exception('系统自带的配置项无法删除');
        }
        //逻辑
        $result = DB::delete('zq_config_list', "cl_id={$id}");
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
            'cli_form_text' => $data['form_text'],
            'cli_data_type' => $data['data_type'],
            'cli_db_field_name' => $data['db_field_name'],
            'cli_default' => $data['default'],
            'cli_order' => $data['order'],
            'cli_cl_id' => $data['addition_id'],
        );
        //检测
        $check = array(
            'cli_form_text' => array('type' => 'required'),
            'cli_data_type' => array('type' => 'required'),
            'cli_db_field_name' => array('type' => 'required'),
            'cli_order' => array('type' => 'number'),
        );
        return Common::addOrEditDbInfo(
            'zq_config_list_item',
            'cli',
            $dbInfo,
            $actionType = $type,
            $option = array('id' => $data['id'], 'check' => $check)
        );
    }
}
