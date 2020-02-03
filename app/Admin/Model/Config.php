<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use app\Model\Define;
use dcr\Db;

class Config
{

    function configBase($info)
    {
        foreach ($info as $key => $value) {
            $dbInfo = array(
                'cb_update_time' => time(),
                'cb_add_user_id' => session('userId'),
                'zt_id' => session('ztId'),
                'cb_name' => $key,
                'cb_value' => $value,
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
            //返回
            return Admin::commonReturn($result);
        }
    }

    function getConfigBaseList()
    {
        $ztId = session('ztId');
        $sql = "select cb_name,cb_value from zq_config_base where zt_id={$ztId}";
        $info = DB::query($sql);
        return $info;
    }

    function getConfigModelList($modelName = '')
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
    function configModel($modelInfo)
    {
        //判断
        //先判断key有没有重复
        $defineList = Define::getModelDefine();
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
}