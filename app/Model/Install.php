<?php


namespace app\Model;

use app\Admin\Model\Admin;
use app\Admin\Model\Factory;
use app\Admin\Model\User;
use dcr\Db;
use dcr\ENV;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Thamaraiselvam\MysqlImport\Import;

class Install
{
    private $sqlFilePath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'sql';

    /**
     * @return string
     */
    public function getSqlFilePath(): string
    {
        return $this->sqlFilePath;
    }

    /**
     * 执行某个目录下的sql文件
     * @param $sqlDirPath
     * @return bool
     * @throws
     */
    public function executeSqlFiles($sqlDirPath)
    {
        ENV::init();
        $host = env('MYSQL_DB_HOST');
        $port = env('MYSQL_DB_PORT');
        $username = env('MYSQL_DB_USERNAME');
        $password = env('MYSQL_DB_PASSWORD');
        $database = env('MYSQL_DB_DATABASE');

        $sqlFileList = scandir($sqlDirPath);
        foreach ($sqlFileList as $sqlFile) {
            if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                $sqlFilename = $sqlDirPath . DS . $sqlFile;
                //echo $sqlFilename;
                //echo '-';
                new Import($sqlFilename, $username, $password, $database, $host . ':' . $port);
            }
        }

        return true;
    }

    public function importDemoData()
    {
        $install = new Install();
        $install->executeSqlFiles($this->sqlFilePath);
        return Admin::commonReturn(1);
    }

    public function install(
        $host,
        $username,
        $password,
        $database,
        $port = 3306,
        $coverData = 1,
        $importDemo = 1,
        $charset = 'utf8'
    ) {

        $lockPath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'lock';
        if (file_exists($lockPath)) {
            throw new \Exception('已经安装过了，如果重新安装，请删除[' . realpath($lockPath) . ']再重新运行本安装程序');
        }

        $envFileExample = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            $data = Env::getData($envFileExample);

            $data['config']['MYSQL_DB_HOST'] = $host;
            $data['config']['MYSQL_DB_PORT'] = $port;
            $data['config']['MYSQL_DB_DATABASE'] = $database;
            $data['config']['MYSQL_DB_USERNAME'] = $password;
            $data['config']['MYSQL_DB_PASSWORD'] = $username;
            $data['config']['MYSQL_DB_CHARSET'] = $charset;
            Env::write($envFile, $data);

            //重新加载配置
            Env::init();
            $container = container();
            $config = $container->make(\dcr\Config::class);
            $config->loadConfig();
            $container->instance(\dcr\Config::class, $config);

            //dd(file_get_contents( $envFile ));

            //用原始的创建
            $conn = mysqli_connect($host, $username, $password, '', $port);
            if ($coverData) {
                mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}` /*zt_id=1*/");
            } else {
                mysqli_query($conn, "CREATE DATABASE `{$database}` /*zt_id=1*/");
            }

            $install = new Install();
            $install->executeSqlFiles($this->sqlFilePath);

            $sqlFileList = scandir($this->sqlFilePath);
            foreach ($sqlFileList as $sqlFile) {
                if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $tableNameArr = explode('_', pathinfo($sqlFile)['filename']);
                    unset($tableNameArr[0]);
                    $tableName = implode('_', $tableNameArr);
                    $truncateSql = "truncate table {$tableName}/*zt_id=0*/";
                    DB::exec($truncateSql);
                }
            }

            //添加role
            $info = array(
                'ur_name' => '系统管理员',
                'ur_note' => '系统最高权限',
                'zt_id' => session('ztId')
            );

            $user = new User();
            $roleId = $user->addRole($info);

            //初始化user
            $userInfo = array(
                'u_username' => 'admin',
                'u_password' => '123456',
                'u_sex' => 1,
                'u_mobile' => '15718126135',
                'u_tel' => '',
                'u_is_super' => 1,
                'u_note' => '管理员',
                'zt_id' => 1,
                'roles' => array(1),
            );
            //返回
            $type = 'add';
            $user->addEditUser($userInfo, $type);

            //权限权限配置
            $user->permissionRefresh();

            //给管理员配置全权限
            $permissionList = $user->getPermissionList();
            $permissionIds = implode(',', array_column($permissionList, 'up_id'));
            DB::update('zq_user_role', array('zt_id' => 1, 'ur_permissions' => $permissionIds,), "ur_name='系统管理员'");

            //系统配置项
            $sqlList = array(
                'INSERT INTO `zq_config_list` VALUES (1,1586603908,1586603908,1,1,1,\'基本配置\',1),(2,1586603908,1586603908,1,1,1,\'模板配置\',1);/*zt_id*/',
                'INSERT INTO `zq_config_list_item` VALUES (1,1586860452,1586969347,1,1,1,\'网站名\',\'varchar\',\'site_name\',1,\'\',1,1),(4,1586938211,1586969157,1,1,1,\'模板名\',\'select\',\'template_name\',1,\'var.systemTemplateStr\',1,2);/*zt_id*/',
                'INSERT INTO `zq_config` VALUES (1,1587050159,1587050174,1,1,1,\'site_name\',\'DcrPHP建站系统11\',1),(2,1587050182,1587050367,1,1,1,\'template_name\',\'default\',2);/*zt_id*/',
            );
            foreach ($sqlList as $sql) {
                DB::exec($sql);
            }

            if ($importDemo) {
                $install->importDemoData();
            }
            //记录已经安装
            file_put_contents($lockPath, date('Y-m-d H:i:s'));

            return Admin::commonReturn(1);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
