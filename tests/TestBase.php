<?php

namespace test;

require_once __DIR__ . '/../dcr/bootstrap/init.php';

use PHPUnit\Framework\TestCase;
use app\Admin\Model\User;
use app\Admin\Model\Model;
use app\Admin\Model\Config;

class TestBase extends TestCase
{
    public function testConfig()
    {
        $config = new Config();

        $modelConfigList = $config->getConfigModelList();

        $this->assertEquals(2, count($modelConfigList));

        //$this->assertEquals(0, count($modelConfigList['info']));
        $this->assertEquals(2, count($modelConfigList['product']));
        $this->assertEquals(1, count($modelConfigList['news']));
    }

    public function testUser()
    {
        $user = new User();
        $userList = $user->getList();

        //判断是不是3个user
        $userCount = count($userList);
        $this->assertEquals(3, $userCount);

        //判断是不是3个有
        $usernameList = array_keys(array_column($userList, 'u_username', 'u_username'));
        //dd($usernameList);
        $this->assertTrue(in_array('admin', $usernameList));
        $this->assertTrue(in_array('张三', $usernameList));
        $this->assertTrue(in_array('李四', $usernameList));

        //有没有空密码的
        $userList = $user->getList(array( 'col'=>'u_id', 'where'=> 'char_length(u_password)<1' ));
        $this->assertEquals(0, count($userList));
    }

    public function testRole()
    {
        $user = new User();

        //是不是2个角色
        $roleList = $user->getRoleList();
        $this->assertEquals(2, count($roleList));

        //admin是不是管理员
        $adminInfo = $user->getInfo('admin');
        $userRole = $user->getRoleConfigList($adminInfo['u_id']);
        $userRole = current($userRole);
        $this->assertEquals(1, $userRole['urc_u_id']);
    }

    public function testModel()
    {
        $model = new Model();

        //分类数目
        $modelProCategoryList = $model->getCategoryList('product');
        $modelNewsCategoryList = $model->getCategoryList('news');
        $modelInfoCategoryList = $model->getCategoryList('info');

        $this->assertEquals(2, count($modelProCategoryList));
        $this->assertEquals(2, count($modelNewsCategoryList));
        $this->assertEquals(1, count($modelInfoCategoryList));

        //把有图片的去掉
        $modelList = $model->getList(array( 'where'=> 'char_length(ml_pic_path)<1'));
        $this->assertEquals(0, count($modelList));

        //list数量
        $modelList = $model->getList(array('requestAddition' => 1, 'col' => 'ml_id,ml_title,ma_id'));
        $this->assertEquals(11, count($modelList));

        //是否有以下几个标题
        $modelTitleList = array_column($modelList, 'ml_title', 'ml_title');

        $this->assertTrue(in_array('联系我们', $modelTitleList));
        $this->assertTrue(in_array('关于我们', $modelTitleList));
        $this->assertTrue(in_array('站内广告优化策略：ACOS应该这样解读才合适', $modelTitleList));
    }

    /**
     * 最基本的测试
     */
    public function testBase()
    {
        //测试文件名对不对
        $dirList = array(
            ROOT_APP . DS . 'Console' . DS . 'sql' . DS . 'install',
        );
        foreach ($dirList as $sqlPath) {
            $fileList = scandir($sqlPath);
            foreach ($fileList as $fileName) {
                if (!in_array($fileName, array('.', '..'))) {
                    $fileArr = explode('_', $fileName);
                    $this->assertEquals('dcrphp', $fileArr[0]);
                }
            }
        }
    }
}
