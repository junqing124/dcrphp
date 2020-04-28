<?php

namespace app\Admin\Plugins\DbBackup\Controller;

use app\Admin\Model\Admin;
use app\Index\Model\Install;
use app\Admin\Model\Plugins;
use dcr\Db;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class DbBackup extends Plugins
{
    private $backupDir = ROOT_APP . DS . 'Admin' . DS . 'Plugins' . DS . 'DbBackup' . DS . 'BackupData';

    /**
     * @param $view本类用来给首页入口调用用的
     */
    public function index($view)
    {
        $dbTableList = Db::query('show tables /*zt_id=1*/');
        $tableList = array();
        foreach ($dbTableList as $tmpInfo) {
            array_push($tableList, current($tmpInfo));
        }
        $view->assign('table_list', $tableList);

        //已有备份
        $backupList = scandir($this->backupDir);
        rsort($backupList);
        $backupListDetail = array();
        foreach ($backupList as $key => $backup) {
            if (in_array($backup, array('.', '..'))) {
                unset($backupList[$key]);
                continue;
            }
            $subBackup = $this->backupDir . DS . $backup;
            $listSubBackup = scandir($subBackup);
            $sqlFile = $listSubBackup[2]; //只备份一个文件，所以用这个写法
            $sqlPath = $subBackup . DS . $sqlFile;
            $sqlFileInfo = pathinfo($sqlPath);
            $sqlFileSize = round(filesize($sqlPath) / 1014, 2);

            $backupListDetail[] = array(
                'name' => $backup,
                'size' => $sqlFileSize,
                'file_name' => $sqlFileInfo['basename']
            );
        }
        $view->assign('backup_list', $backupListDetail);
    }

    public function restore($data)
    {
        $backupName = $data['backup_name'];
        $dirPath = $this->backupDir . DS . $backupName;
        $clsInstall = new Install();
        $clsInstall->executeSqlFiles($dirPath);
        return Admin::commonReturn(1);
    }

    public function remove($data)
    {
        $backupName = $data['backup_name'];
        $dirPath = $this->backupDir . DS . $backupName;

        $fileSystem = new Filesystem();
        try {
            $fileSystem->remove($dirPath);
        } catch (IOExceptionInterface $ex) {
            throw new \Exception($ex->getMessage());
        }
        return Admin::commonReturn(1);
    }

    /**
     * 这里从哪来的，可以看view下的index里的注释
     * @param $data
     */
    public function backup($data)
    {
        $tableList = $data['table'];
        //开始备份表
        //开始准备工作

        $backupDir = $this->backupDir . DS . date('Y-m-d-H-i');
        $fileSystem = new Filesystem();
        try {
            $fileSystem->mkdir($backupDir);
        } catch (IOExceptionInterface $ex) {
            throw new \Exception($ex->getMessage());
        }

        if (!file_exists($backupDir)) {
            throw new \Exception('目录不存在，创建目录失败:' . $backupDir);
        }

        require_once $this->getPluginDir('DbBackup') . DS . 'vendor' . DS . 'autoload.php';

        try {
            $backupName = $backupDir . DS . 'backup';
            $clsDump = new \Phelium\Component\MySQLBackup(
                env('MYSQL_DB_HOST'),
                env('MYSQL_DB_USERNAME'),
                env('MYSQL_DB_PASSWORD'),
                env('MYSQL_DB_DATABASE'),
                env('MYSQL_DB_PORT')
            );
            $clsDump->addTables($tableList);
            $clsDump->setFilename($backupName);
            $clsDump->dump();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return Admin::commonReturn(1);
    }
}
