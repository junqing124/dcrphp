[![Build Status](https://travis-ci.org/junqing124/dcrphp.svg?branch=master)](https://travis-ci.org/junqing124/dcrphp) 
[![Coverage Status](https://coveralls.io/repos/github/junqing124/dcrphp/badge.svg?branch=master)](https://coveralls.io/github/junqing124/dcrphp?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/junqing124/dcrphp/v/stable.png)](https://packagist.org/packages/junqing124/dcrphp) 
[![Latest Unstable Version](https://poser.pugx.org/junqing124/dcrphp/v/unstable.png)](https://packagist.org/packages/junqing124/dcrphp)  

dcrphp后端是自己开发的框架，采用前后端分离的方式做的管理系统，自带模型管理及后台管理系统。可以很方便在上面自由的扩展。特点如下:  
&nbsp;&nbsp;1、自带后台管理  
&nbsp;&nbsp;2、自带模型方便扩展  
&nbsp;&nbsp;3、后台自带RABC  
&nbsp;&nbsp;4、MVC模式  
&nbsp;&nbsp;5、有自动化的测试及编码检测  
  
安装源码(下面3选1)：  

    1、composer create-project junqing124/dcrphp dcrphp 1.0.1
    2、进入根目录执行:
        composer require junqing124/dcrphp  1.0.1  
        把vender/junqing124/dcrphp/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/junqing124/dcrphp/tags 下载需要的版本，解压后:  
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
        composer install --no-dev -vvv  
        
 
下载好源码后，进入根目录安装系统:  

    php dcrphp app:install 数据库host 数据库端口 用户名 密码 数据库名   
    比如  
    php dcrphp app:install 127.0.0.1 3306 root root dcrphp utf8  
    安装完成后，后台地址是 host/admin/index/index 初始化用户名和密码是admin 123456  

    如果要导入测试数据:    
    php dcrphp app:demo    
  
  
附：nginx配置:  
charset utf-8;  
location / {  
&#8195;&#8195;try_files $uri $uri/ /index.php?$query_string;    
}  

1.0.2(开发中):  
    1、完善RABC  
    2、完善测试程序  
    3、修改数据库规则及现有的数据库结构  
    4、插件中心  

1.0.1(2020-03-15):  
    1、采用全新的底层框架，性能、开发效率提升  
    2、后台前后端方式开发，人性化提升  
    3、模板引擎使用twig，更健壮  
    4、采用模型方式，系统扩展性更强  

