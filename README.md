安装：  
进入根目录执行:  
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
composer install --no-dev  
如果更新则为 composer update --no-dev  
php dcrphp app:install 数据库host 数据库端口 用户名 密码 数据库名 
比如  
php dcrphp app:install 127.0.0.1 3306 root root dcrphp  
后台地址是 host/admin/index/index 初始化用户名和密码是admin 123456  

导入测试数据:  
php dcrphp app:demo  

nginx记得配置:  
charset utf-8;  
location / {  
    try_files $uri $uri/ /index.php?$query_string;  
}  
