<?php

namespace app\Console;

use app\Admin\Model\User as MUser;
use app\Model\Install;
use dcr\Env;
use dcr\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thamaraiselvam\MysqlImport\Import;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppInstall extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:install'); //注意这个是命令行
        $this->addArgument('host', InputArgument::REQUIRED, 'database host');
        $this->addArgument('port', InputArgument::REQUIRED, 'database host port');
        $this->addArgument('username', InputArgument::REQUIRED, 'database username');
        $this->addArgument('password', InputArgument::REQUIRED, 'database password');
        $this->addArgument('database', InputArgument::REQUIRED, 'database name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump(ini_get('safe_mode'));
        var_dump(putenv("PHP_a=b"));
        echo getenv('PHP_a');
        exit;
        //start install
        //change the env
        $envFileExample = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            $io = new SymfonyStyle($input, $output);

            $io->title('Config start');
            //$output->writeln();
            $data = Env::getData($envFileExample);

            $host = $input->getArgument('host');
            $port = $input->getArgument('port');
            $username = $input->getArgument('username');
            $password = $input->getArgument('password');
            $database = $input->getArgument('database');

            $data['config']['MYSQL_DB_HOST'] = $host;
            $data['config']['MYSQL_DB_PORT'] = $port;
            $data['config']['MYSQL_DB_DATABASE'] = $database;
            $data['config']['MYSQL_DB_USERNAME'] = $password;
            $data['config']['MYSQL_DB_PASSWORD'] = $username;
            Env::write($envFile, $data);
            //dd(file_get_contents( $envFile ));

            $io->title('Config success');
            $io->title('Sql import start');

            //用原始的创建
            $conn = mysqli_connect($host, $username, $password, '', $port);
            mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}` /*zt_id=1*/");

            $sqlFilePath = ROOT_APP . DS . 'Console' . DS . 'sql' . DS . 'install';
            $install = new Install();
            $install->executeSqlFiles($sqlFilePath);

            $io->title('Sql import end');
            $io->title('Initial start');

            $sqlFileList = scandir($sqlFilePath);
            foreach ($sqlFileList as $sqlFile) {
                if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $tableNameArr = explode('_', pathinfo($sqlFile)['filename']);
                    unset($tableNameArr[0]);
                    $tableName = implode('_', $tableNameArr);
                    $truncateSql = "truncate table {$tableName}/*zt_id=0*/";
                    mysqli_query($conn, $truncateSql);
                }
            }

            //添加role
            $info = array(
                'ur_name' => post('系统管理员'),
                'ur_note' => post('系统最高权限')
            );

            $user = new MUser();
            $roleId = $user->addRole($info);

            //初始化user
            $userInfo = array(
                'u_username' => 'admin',
                'u_password' => '123456',
                'u_sex' => 1,
                'u_mobile' => '15718126135',
                'u_tel' => '',
                'u_note' => '管理员',
                'zt_id' => 1,
                'roles' => array($roleId),
            );
            //返回
            $type = 'add';

            //dd($type);
            //dd(get());
            $user = new MUser();
            $user->addEditUser($userInfo, $type);

            $io->title('Initial end');
            $io->title('Install success, you can login in by host/admin/index/index admin,123456');

        } catch (\Exception $e) {
            throw $e;
        }

    }
}