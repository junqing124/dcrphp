下载进入根目录后执行
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
composer install --no-dev
如果更新则为 composer update --no-dev

安装为：
进入根目录执行:
php dcrphp app:install 127.0.0.1 3306 root root zhanqqq
php dcrphp app:install 数据库host 数据库端口 用户名 密码 数据库名

nginx记得配置:
charset utf-8;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

后台地址是 host/admin/index/index 初始化用户名和密码是admin 123456