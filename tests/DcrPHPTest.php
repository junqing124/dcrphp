<?php
require __DIR__ . '/../dcr/bootstrap/init.php';

use PHPUnit\Framework\TestCase;
use app\Admin\Model\User;
use dcr\DB;

class DcrPHPTest extends TestCase
{
    function testUser()
    {
        $user = new User();
        $userList = $user->getList();

        //判断是不是3个user
        $userCount = count($userList);
        $this->assertEquals(3, $userCount);

        //判断是不是3个有
        $usernameList = array_keys( array_column( $userList, 'u_username', 'u_username' ) );
        //dd($usernameList);
        $this->assertTrue( in_array('admin', $usernameList ) );
        $this->assertTrue( in_array('张三', $usernameList ) );
        $this->assertTrue( in_array('李四', $usernameList ) );

    }

    function testRole()
    {
        $this->assertTrue( false );
    }
}