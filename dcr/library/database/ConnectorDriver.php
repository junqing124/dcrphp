<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/31
 * Time: 1:35
 */

namespace dcr\database;

use Aura\SqlQuery\QueryFactory;
use dcr\Session;

/**
 * Class ConnectorDriver
 * 数据库连接
 * 这里实现了数据库连接及CURD操作
 * @package dcr\database
 */
abstract class ConnectorDriver
{
    /**
     * @var 数据库连接结果
     */
    protected $pdo;
    /**
     * @var 最后的sql
     */
    protected $lastSql;
    /**
     * @var 最后的错误id
     */
    protected $lastErrorCode;
    /**
     * @var 最后的错误信息
     */
    protected $lastErrorInfo;

    abstract function getDsn();

    /**
     * 执行select
     * @param $sql sql语句
     * @return array 结果
     * @throws \Exception
     */
    function query($sql)
    {
        if (!$this->checkZtId($sql)) {
            throw new \Exception('没有帐套ID:' . $sql);
        }
        $this->lastSql = $sql;
        $result = $this->pdo->query($sql);
        $this->recordError($this->pdo);
        return $this->getAllRow($result);
    }

    /**
     * 执行非sql语句
     * @param $sql sql语句
     * @return mixed 返回结果
     * @throws \Exception
     */
    function exec($sql)
    {
        if (!$this->checkZtId($sql)) {
            throw new \Exception('没有帐套ID');
        }
        $this->lastSql = $sql;
        $result = $this->pdo->exec($sql);
        $this->recordError($this->pdo);
        return $result;
    }

    /**
     * 执行prepare语句
     * @param $sql sql语句
     * @return mixed 返回结果
     * @throws \Exception
     */
    function prepare($sql)
    {
        if (!$this->checkZtId($sql)) {
            throw new \Exception('没有帐套ID');
        }
        $result = $this->pdo->prepare($sql);
        return $result;
    }

    function getAllRow($pdoStatement)
    {
        $result = array();
        if ($pdoStatement) {
            $result = $pdoStatement->FetchAll(\PDO::FETCH_ASSOC);
        }
        return $result;
    }

    /**
     * 检查有没有帐套id
     * @param $sql
     * @return boolean 有返回true 没有返回false
     */
    function checkZtId($sql)
    {
        return strpos($sql, 'zt_id') > 0;
    }

    /**
     * @param $option 参数为:
     * table:表名
     * where:数组或字符串
     * limit:
     * order:
     * offset:
     * group:
     * join: 多个请用join数组 比如 array(array(),array()),如果只是一个则一个即可array() 格式: array('type'=> 类型, 'table'=> 连接的表 'condition'=> 连接条件)
     * @return mixed
     * @throws
     */
    function select($option)
    {
        $queryFactory = new QueryFactory(config('database.type'));
        //判断用户名有没有
        $select = $queryFactory->newSelect();
        $ztId = Session::_get('ztId');
        $col = $option['col'] ? $option['col'] : array('*');
        if (!is_array($col)) {
            $col = array($col);
        }
        $select->from($option['table'])->cols($col)->where("{$option['table']}.zt_id={$ztId}");
        if ($option['order']) {
            $select->orderBy(array($option['order']));
        }
        if ($option['limit']) {
            $select->limit($option['limit']);
        }
        if ($option['offset']) {
            $select->offset($option['offset']);
        }
        if ($option['group']) {
            $select->group($option['group']);
        }
        if ($option['join']) {
            if (3 == count($option['join']) && $option['join']['type']) {
                $option['join'] = array($option['join']);
            }
            //dd($option);
            foreach ($option['join'] as $joinDetail) {
                $select->join($joinDetail['type'], $joinDetail['table'], $joinDetail['condition']);
            }
        }
        //dd($option);
        $whereStr = '';
        if ($option['where']) {
            if (is_array($option['where'])) {
                $whereStr = implode(' and ', $option['where']);
            } else {
                $whereStr = $option['where'];
            }
            $select->where($whereStr);
        }
        $sql = $select->getStatement();
        //echo $sql;
        $list = $this->query($sql);
        return $list;
    }

    /**
     * @param $table
     * @param $info
     * @param $where
     * @return mixed
     * @throws
     */
    function update($table, $info, $where)
    {
        $ztId = Session::_get('ztId');
        $queryFactory = new QueryFactory(config('database.type'));
        $update = $queryFactory->newUpdate();
        $update
            ->table($table)
            ->where($where)
            ->cols($info)
            ->where("zt_id={$ztId}");
        $dbPre = $this->prepare($update->getStatement());
        $result = $dbPre->execute($update->getBindValues());
        $this->recordError($dbPre);
        return $result;
    }

    /**
     * @param $table
     * @param $where
     * @return mixed
     * @throws \Exception
     */
    function delete($table, $where)
    {
        $ztId = Session::_get('ztId');
        $queryFactory = new QueryFactory(config('database.type'));
        $delete = $queryFactory->newDelete();
        $delete
            ->from($table)
            ->where($where)
            ->where("zt_id={$ztId}");
        $dbPre = $this->prepare($delete->getStatement());
        $result = $dbPre->execute($delete->getBindValues());
        $this->recordError($dbPre);
        return $result;
    }

    /**
     * @param $table
     * @param $info
     * @return mixed
     * @throws
     */
    function insert($table, $info)
    {
        $queryFactory = new QueryFactory(config('database.type'));
        $insert = $queryFactory->newInsert();
        $insert->into($table)->cols(array_keys($info))->bindValues($info);
        $dbPre = $this->prepare($insert->getStatement());
        $insertSql = $insert->getBindValues();
        if ($dbPre->execute($insertSql)) {
            $result = $this->pdo->lastInsertId();
        } else {
            $result = 0;
        }
        $this->recordError($dbPre);

        return $result;
    }

    function getError()
    {
        return array('code' => $this->lastErrorCode, 'msg' => implode(',', $this->lastErrorInfo));
    }

    function getLastSql()
    {
        return $this->lastSql;
    }

    private function recordError($pdo)
    {
        $this->lastErrorCode = $pdo->errorCode();
        $this->lastErrorInfo = $pdo->errorInfo();
        return 1;
    }

    function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    function commit()
    {
        $this->pdo->commit();
    }

    function rollBack()
    {
        $this->pdo->rollBack();
    }
}