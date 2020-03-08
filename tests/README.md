本测试是基于:
php dcrphp app:install 127.0.0.1 3306 root root dcrphp  
php dcrphp app:demo  

然后执行:
cd tests
php ../vendor/phpunit/phpunit/phpunit --verbose DcrPHPTest

人工测试点：
导入测试数据后：
1、有没有网站名