<?php

namespace app\Console;

use dcr\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ConsoleMake extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('console:make'); //注意这个是命令行
        $this->addArgument('consoleName', InputArgument::REQUIRED, 'console name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consoleName = $input->getArgument('consoleName');
        $className = Console::_consoleNameToClassName($consoleName);
        $classFile = Console::_getConsoleClassPath($className);

        if (file_exists($classFile)) {
            throw new \Exception('Console Name is exists,you can remove this console by php dcrphp console:remove console:name');
            exit;
        }
        //has exists class

        $tpl = file_get_contents(__DIR__ . DS . 'template' . DS . 'ConsoleTpl.php');

        //replace
        $tpl = str_replace('ConsoleName', $className, $tpl);
        $tpl = str_replace('console:name', $consoleName, $tpl);

        try {
            file_put_contents($classFile, $tpl);
            echo "We make the console,you can try it:php dcrphp {$consoleName}";
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
