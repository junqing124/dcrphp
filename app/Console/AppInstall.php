<?php

namespace app\Console;

use app\Index\Model\Install;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 本命令行的存在是为了命令行中安装用的(travis)
 */
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
        $this->addArgument('charset', InputArgument::REQUIRED, 'character set');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $input->getArgument('host');
        $port = $input->getArgument('port');
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $database = $input->getArgument('database');
        $charset = $input->getArgument('charset');

        $clsInstall = new Install();
        $clsInstall->install(
            $host,
            $username,
            $password,
            $database,
            $port,
            1,
            1,
            $charset
        );

        return 0;
    }
}
