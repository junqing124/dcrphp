<?php

namespace app\Console;

use app\Model\Install;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class PluginMake extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('plugin:make'); //console name:php dcrphp plugin:make
        $this->addArgument('plugin_name', InputArgument::REQUIRED, 'plugin name');
        $this->addArgument('title', InputArgument::REQUIRED, 'title,less than 10');
        $this->addArgument('description', InputArgument::REQUIRED, 'description');
        $this->addArgument('author', InputArgument::REQUIRED, 'author,you name or email');
        $this->addArgument('version', InputArgument::REQUIRED, 'version,example 1.0.1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $pluginName = $input->getArgument('plugin_name');
            $title = $input->getArgument('title');
            $description = $input->getArgument('description');
            $author = $input->getArgument('author');
            $version = $input->getArgument('version');
            $io = new SymfonyStyle($input, $output);
            $io->title('make start:');
            $tplDir = __DIR__ . DS . 'template' . DS . 'Plugin';
            $fileSystem = new Filesystem();
            $targetDir = ROOT_APP . DS . 'Plugins' . DS;
            $pluginDir = $targetDir . DS . $pluginName;
            $fileSystem->mirror($tplDir, $targetDir, null, ['override' => false, 'delete' => false]);
            $fileSystem->rename($targetDir . DS . 'PluginTpl', $pluginDir);

            //开始改内容
            $controllerFilePathOld = $pluginDir . DS . 'Controller' . DS . 'PluginTpl' . '.php';
            $controllerFilePath = $pluginDir . DS . 'Controller' . DS . $pluginName . '.php';

            $fileSystem->rename($controllerFilePathOld, $controllerFilePath);
            $tplContent = file_get_contents($controllerFilePath);
            $pluginContent = str_replace('PluginTpl', $pluginName, $tplContent);
            file_put_contents($controllerFilePath, $pluginContent);

            $configContent = <<<CODE
<?php
return array(
    'name'=> '{$pluginName}', //与目录名相同
    'description'=> '{$description}',
    'title'=> '{$title}', //菜单栏上显示的
    'author'=> '{$author}',
    'version'=> '{$version}',
);
CODE;
            $configFilePath = $pluginDir . DS . 'Config.php';
            file_put_contents($configFilePath, $configContent);
            $io->title('make end,the plugin directory in app\Plugins');
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
