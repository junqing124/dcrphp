<?php
/**
 * 模拟后台测试
 */

namespace test;

require_once __DIR__ . '/../dcr/bootstrap/init.php';

use PHPUnit\Framework\TestCase;
use app\Admin\Model\User;

class TestWeb extends TestCase
{
    public function testWeb()
    {
        //登陆
        $user = new User();
        $user->login(1);

        //临时登陆
        $code = <<<CODE
<?php
namespace app\Admin\Controller;
use app\Admin\Model\User;

class Tmp
{
    public function login()
    {
        \$user = new User();
        \$user->login(1);
    }
}
CODE;
        $tmpDir = ROOT_APP . DS . 'Admin' . DS . 'Controller';
        $tmpFile = $tmpDir . DS . 'Tmp.php';
        file_put_contents($tmpFile, $code);
        echo file_get_contents('http://127.0.0.1:84/admin/tmp/login');
        echo file_get_contents('http://127.0.0.1:84/admin/index/index');

        //删除
        unlink($tmpFile);
        $this->assertFalse(file_exists($tmpFile));
    }
}
