<?php
namespace app\Console;

use dcr\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleRemove extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('console:remove'); //console name:php dcrphp console:remove
        $this->addArgument('consoleName', InputArgument::REQUIRED, 'console name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consoleName = $input->getArgument('consoleName');
        $className = Console::_consoleNameToClassName($consoleName);
        $classFile = Console::_getConsoleClassPath($className);
        if (!file_exists($classFile)) {
            throw new \Exception('Console Name is not exists');
            exit;
        }

        @unlink($classFile);
        if (file_exists($classFile)) {
            throw new \Exception('Console remove failed, you can remove the file in app\Console');
            exit;
        }
        echo "remove console success";
    }
}