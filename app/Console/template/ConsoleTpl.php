<?php
namespace app\Console;

use app\Model\Install;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleName extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('console:name'); //console name:php dcrphp console:name
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            $io = new SymfonyStyle($input, $output);
            $io->title('this is command');
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
