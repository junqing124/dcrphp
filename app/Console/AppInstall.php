<?php

namespace app\Console;

use app\Admin\Model\User as MUser;
use dcr\Env;
use dcr\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thamaraiselvam\MysqlImport\Import;

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
        //start install
        //change the env
        $envExampleFile = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            echo "Config start \r\n";
            $data = Env::getData($envExampleFile);

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

            Env::write($envFile, $data );
            echo "Config success \r\n";
            echo "Sql import start \r\n";
            $sqlFilePath = ROOT_APP . DS . 'Console' . DS . 'sql' . DS . 'install';
            $sqlFileList = scandir($sqlFilePath);
            foreach ($sqlFileList as $sqlFile) {
                if ( pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $sqlFilename = $sqlFilePath . DS . $sqlFile;
                    new Import($sqlFilename, $username, $password, $database, $host . ':' . $port);
                }
            }
            echo "Sql import end \r\n";
            echo "Initial start \r\n";

            foreach ($sqlFileList as $sqlFile) {
                if ( pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $tableNameArr = explode('_', pathinfo($sqlFile)['filename']);
                    unset($tableNameArr[0]);
                    $tableName = implode('_', $tableNameArr);
                    DB::exec("truncate table {$tableName}/*zt_id=0*/");
                }
            }

            //初始化user

            $userInfo = array(
                'u_username' => 'admin',
                'u_password' => '123456',
                'u_sex' => 1,
                'u_mobile' => '15718126135',
                'u_tel' => '',
                'u_note' => '管理员',
                'zt_id' => 1,
            );
            //返回
            $type = 'add';

            //dd($type);
            //dd(get());
            $user = new MUser();
            $user->addEditUser($userInfo, $type);
            echo "Initial end \r\n";
            echo "Install success, you can login in by host/admin/index/index admin,123456";

        } catch (\Exception $e) {
            throw $e;
        }

    }
}