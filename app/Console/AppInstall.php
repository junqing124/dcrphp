<?php
namespace app\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppInstall extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:install'); //注意这个是命令行
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("test");
    }
}