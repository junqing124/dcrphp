<?php

namespace app\Console;

use app\Admin\Model\Admin;
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
        //根据app\Admin来生成权限列表
        $dirList = array(
            ROOT_APP . DS . 'Admin' . DS . 'Controller',
        );
        $io = new SymfonyStyle($input, $output);
        $permissionList = array();
        foreach ($dirList as $dir) {
            $fileList = scandir($dir);
            foreach ($fileList as $fileName) {
                if (in_array($fileName, array('.', '..'))) {
                    continue;
                }
                $filePath = $dir . DS . $fileName;
                $factory = DocBlockFactory::createInstance();
                $docBlock = $factory->create(file_get_contents($filePath));
                $permissionTag = $docBlock->getTagsByName('permission');
                foreach ($permissionTag as $permissionGeneric) {
                    $permissionConfigName = $permissionGeneric->getDescription()->render();
                    //判断格式
                    if (substr($permissionConfigName, 1) == '/' || substr($permissionConfigName, -1) == '/') {

                        throw new \Exception($permissionConfigName . '  不规范,权限名请以/开头，结尾不要/，且以一个/做分隔');
                    }
                    if (preg_match("/\/{2,}/u", $permissionConfigName, $out)) {
                        throw new \Exception($permissionConfigName . '  不规范,权限名请以/开头，结尾不要/，且以一个/做分隔');
                    }
                    $permissionList[] = $permissionConfigName;
                }
            }
        }
        if (!$permissionList) {
            $io->title('Find nothing permission config');
            exit;
        }
        //判断有没有重复的
        $permissionListNew = array_unique($permissionList);
        if (count($permissionListNew) != count($permissionList)) {
            $io->title('Find the same permission config');
            exit;
        }
        //添加到权限表中
        //定义一个版本号，如果没有，则说明不是本次更新，删除之
        $version = uniqid();
        foreach ($permissionList as $permissionName) {
            $dbInfo = array(
                'up_update_time' => time(),
                'up_name' => $permissionName,
                'up_version' => $version,
                'up_add_user_id'=> 0,
                'zt_id' => session('ztId'),
            );
            $hasInfo = DB::select(array(
                'table' => 'zq_user_permission',
                'col' => 'up_id',
                'where' => "up_name='{$permissionName}'"
            ));
            //判断有没有
            if (!$hasInfo) {
                $dbInfo['up_add_time'] = time();
                $result = DB::insert('zq_user_permission', $dbInfo);
            } else {
                $hasInfo = current($hasInfo);
                $result = DB::update('zq_user_permission', $dbInfo, "up_id={$hasInfo['up_id']}");
            }
        }
        //非本版本的删除 这样做的原因是删除那些已经删除的权限
        DB::delete('zq_user_permission', "up_version!='{$version}'");
        $io->title('Permission refresh finished!');
    }
}
