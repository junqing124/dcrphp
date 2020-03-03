<?php
namespace app\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\Model\Install;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * 初始化数据，用来测试观察
 * Class AppInit
 * @package app\Console
 */
class AppDemo extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:demo'); //console name:php dcrphp app:init
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //初始化数据

        try {
            $io = new SymfonyStyle($input, $output);
            $sqlFilePath = ROOT_APP . DS . 'Console' . DS . 'sql' . DS . 'demo';
            $install = new Install();
            $install->executeSqlFiles($sqlFilePath);
            $io->title('Import demo finished');
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
