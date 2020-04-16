<?php
/**
 * 登陆后台测试链接是否正常
 */

namespace test;

require_once __DIR__ . '/../dcr/bootstrap/init.php';

use PHPUnit\Framework\TestCase;

class TestWeb extends TestCase
{
    public function testWeb()
    {
        //取消登陆
        $userPath = ROOT_APP . DS . 'Admin' . DS . 'Model' . DS . 'User.php';
        $userCode = file_get_contents($userPath);

        $ignoreYz = <<<YZCODE
                \$result = array();
                \$result['ack'] = 1;
                \$result['data'] = array(
                    'ztId' => 1,
                    'userId' => 1,
                    'username' => 'admin',
                    'password' => 'dcJ49.bznhA7c',
                );
YZCODE;

        $userCodeNew = str_replace('//本代码不要删除，为了给TestWeb测试模块去除验证用//', $ignoreYz, $userCode);
        file_put_contents($userPath, $userCodeNew);
        //首页
        $html = file_get_contents('http://127.0.0.1/admin/index/index');
        $this->assertRegExp('/我的桌面/', $html);

        try {
            //有些要附加参数才能自动化访问
            $additionCs = array(
                'passwordchangeview' => '?user_id=1',
                'roleeditpermissionview' => '?role_id=1',
            );
            //幸好当初定好了命名规则，这里统一定查下有没有非正常的页面
            //获取admin下的所有view看下
            $adminPath = ROOT_APP . DS . 'Admin' . DS . 'Controller';
            $classFileList = scandir($adminPath);
            foreach ($classFileList as $classFileName) {
                if (!in_array($classFileName, array('.', '..'))) {
                    $fileInfo = pathinfo($classFileName);
                    $className = 'app\\Admin\\Controller\\' . $fileInfo['filename'];
                    $reflector = new \ReflectionClass($className);
                    $methodList = $reflector->getMethods();
                    foreach ($methodList as $methodDetail) {
                        $methodNameLower = strtolower($methodDetail->name);
                        if ('view' == substr($methodNameLower, -4)) {
                            $classNameArr = explode(DS, strtolower($className));
                            //dd($classNameArr);
                            $viewUrl = 'http://127.0.0.1/' . $classNameArr[1] . '/' . $classNameArr[3] . '/' . $methodNameLower . $additionCs[$methodNameLower];
                            echo $viewUrl . "\r\n";
                            //exit;
                            $html = file_get_contents($viewUrl);

                            $this->assertRegExp('/stylesheet/', $html);
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            file_put_contents($userPath, $userCode);
            echo $ex->getMessage();
        } finally {
            file_put_contents($userPath, $userCode);
        }
    }

    /**
     * 判断下文件有没有恢复
     */
    public function testCode()
    {
        $userPath = ROOT_APP . DS . 'Admin' . DS . 'Model' . DS . 'User.php';
        $userCode = file_get_contents($userPath);
        $this->assertRegExp('/本代码不要删除，为了给TestWeb测试模块去除验证用/', $userCode);
    }
}
