<?php

namespace app\Console;

use app\Admin\Model\Admin;
use app\Admin\Model\User;
use dcr\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Console\Style\SymfonyStyle;

class PermissionRefresh extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('permission:refresh'); //console name:php dcrphp permission:refresh
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $user = new User();
        $user->permissionRefresh();
        $io->title('Permission refresh finished!');

        return 0;
    }
}
