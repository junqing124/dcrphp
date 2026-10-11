未来开发:  
　　1、SSO单点登陆  
　　2、事件机制  
　　3、重构request及response  
　　4、dcrphp core独立成包提供输出  
　　5、重建权限系统  
　　6、代码生成器  
　　7、单表导入导出  
　　8、插件导入导出  

1.0.7-alpha10(20261011)  
　　1、修正Model类下的分类html:在同一个页面中多次生成分类的html会叠加  
　　2、增加DB创建表时插件几个快速选项  

1.0.7-alpha10(20240423)  
　　1、修正DB类select的join增加一个table_as别名  

1.0.7-alpha9  
　　1、增加env提示  

1.0.7-alpha8  
　　1、修正权限bug  

1.0.7-alpha7  
　　1、App增加debug参数，用于自由开发  

1.0.7-alpha6  
　　1、修正View的render json  

1.0.7-alpha5  
　　1、修正添加会员的bug  
　　2、修正dcrphp/container新的版本  

1.0.7-alpha4  
　　1、修正上传产品图片产生的BUG  

1.0.7-alpha3  
　　1、单表管理增加了数据列表    

1.0.7-alpha2  
　　1、修正一些基本BUG    

1.0.7-alpha1  
　　1、增加getCategorySelectHtml的选项  
　　2、增加单表列表页本人添加的信息才能编辑和删除  
　　3、增加单表列表页查看功能  
　　4、单表列表增加展示类型  
　　5、增加模组列表页本人添加的信息才能编辑和删除  
　　6、增加单表列表页列排序(越小排越前，默认是100)  
　　7、属性组管理(某分组的属性管理，主要用于对某信息的扩展属性，比如可用于订单的附加属性管理)  
　　8、修正自定义日志记录的BUG(在ajax请求下，自定义日志失效)  
　　9、修正sqlite下的转义BUG  
　　10、增加Attribute类  
　　11、修正DB的bug  

1.0.6(20201015)  
　　1、修正模板选择项bug  

1.0.6-rc2(20201012)  
　　1、修正Common::CUDDbInfo添加数据时没有转义的BUG  
　　2、集成Psysh用于制作内置命令行，使用php dcrphp console:shell启动  
　　3、修正或增强request.uploads  
　　4、修正[插件/数据库管理]，[删除本行]按钮无效，及一些默认字段的注释  
　　5、[单表管理]里的默认字段支持从配置、变量、数据库等来源取数  
　　6、修正DB类中select的group  
　　7、[单表管理]可以导出sql  

1.0.6-rc1(20200928) 
　　1、菜单布局优化  
　　2、登陆页改样式  

1.0.6-alpha3(20200925)  
　　1、修正获取get或post值为0时无法获取的BUG  
　　2、使用dcrphp/container替换dcr/Container，dcrphp/container提供了丰富的开箱即用的组件,具体可以看https://github.com/dcrphp/container  
　　3、输出变量增加function pr() 原来的dd或dump已经被占用了  
　　4、js添加对checkbox的操作  
　　5、字段的update_time完善  
　　6、后台菜单改版  
　　7、增加Log::browserLog输出日志在浏览器可看  
　　8、为方便做页面说明，页面增加提示信息及信息设置:在每个页面编辑区的右上角  

1.0.6-alpha2(20200827)  
　　1、计划任务中心  
　　2、[系统工具/插件中心/数据库管理]表默认字段加上注释  
　　3、鼓励用[系统工具/插件中心/数据库管理]创建表以产生标准表  
　　3、修正创建表的时候全部添加了唯一索引的BUG及判断默认值是否有添加  
　　4、修正单表管理属性选中失效的BUG  
　　5、增加单表管理中双击字段可以直接编辑功能  

1.0.6-alpha1(20200817)   
　　1、增加php dcrphp list/help/-h等功能  
　　2、增加查看某个命令的帮助如:php dcrphp help console:make  
　　3、文件管理及在线代码编辑  
　　4、增加一种短地址实现功能:config/route/web.php    

1.0.5(20200807)  
　　1、修正创建命令行没有返回值的bug

1.0.5-rc1(20200729)  
　　1、修正sqlite目录获取不正确的bug  
　　2、自动建立storage目录  
　　3、错误处理分为php及dcrphp，前者为php自己处理或展示错误，后者为dcrphp来处理或展示  
　　4、修正后台新增自定义配置项无法正确配置的问题  
　　5、插件新增数据库处理插件  
　　6、修正命令行新建插件命名空间有问题的BUG  
　　7、新增单表中心    
　　8、API新增获取任意数据的接口，但要在api权限里配置权限  

1.0.5-alpha2(20200721)  
　　1、验证码后台配置要不要开启，还有难度  
　　2、tests/TestWeb用新方式做自动做检测  
　　3、修正登陆没有验证码也能登录的bug  
　　4、修正init时不显示错误的bug  
　　5、支持sqlite  
　　6、API中心  
　　7、response完善  
　　8、编码规则升级为PSR12  
　　9、修正登陆IP不准确的BUG  

1.0.5-alpha1(20200713)  
　　1、修正会员修改男女性别有问题  
　　2、修正dcr/facade/Log::systemLog丢失键的BUG  
　　3、日志默认按天存    
　　4、app添加ModelList目录放置用户自己的model  
　　5、增加Error支持cli显示错误  
　　6、PHPUnit检测增加检测表结构如果有notnull，没有默认值则报错  

1.0.4(20200710)  
　　1、测试通过，正式上线1.0.4  

1.0.4-rc2(20200709)  
　　1、修正添加会员的BUG  
　　2、修正删除会员不删除角色配置的BUG  
　　3、修正table edit字段管理没有title还有多余数据类型的BUG  
　　4、备份插件中，备份目录不存在则自动创建目录    

1.0.4-rc1(20200708)  
　　1、修正登陆次数改为0  
　　2、Log::systemLog()写日志时storage路径修正  
　　3、storage固定到public目录    

1.0.4-alpha4(20200704)  
　　1、修正model删除field和addition没删除的bug  
　　2、增强phpunit检测功能  
　　3、模型名称改为模组   
　　4、清理demo里的异常数据   
　　5、修改表的结构，加索引   
　　6、修正模组图片存数据及后台显示问题问题   
　　7、后台左上角增加快捷入口   
　　8、程序由dcrphp framework改为dcrphp core   

1.0.4-alpha3(2020.06.30)  
　　1、增加log的开关:LOG_ENABLE，默认是0  
　　2、log的默认改为是directory    
　　2、增加操作log的门脸:dcr/facade/Log    

1.0.4-alpha2(2020.06.28)  
　　1、修正页面安装的bug  

1.0.4-alpha1(2020.06.26)  
　　1、代码组织三层分层  
　　2、缓存:dcrphp/cache  
　　3、注解中心  
　　4、配置:dcrphp/config  
　　5、table edit全新案例及修正bug  
　　6、日志:dcrphp/log   
　　7、集成用户日志和系统日志  
　　8、集成Doctrine ORM  
　　9、修正编辑器bug及ignore  
　　10、增加门脸  
    
1.0.3(2020-05-12)  
　　1、部份文件重新组织  
　　2、后台JS统一化  
　　3、模型页面配置  
　　4、单表管理配置  
　　5、数据库规范制定  
　　6、Db类加上获取最后sql的功能，以方便数据库调试  
　　7、错误提示使用的是filp/whoops  

1.0.2(2020-04-17):  
　　1、完善RABC  
　　2、完善测试程序  
　　3、修改数据库规则及现有的数据库结构  
　　4、新增插件中心  
　　5、插件中心内置增加：生成表结构、数据库管理  
　　6、简单的route生效，配置在config/route，key->value来简化route  
　　7、安装web化  
　　8、默认关闭debug模式  
　　9、模板可配置  
　　10、配置中心可配置化  

1.0.1(2020-03-15):  
　　1、采用全新的底层框架，性能、开发效率提升  
　　2、后台前后端方式开发，人性化提升  
　　3、模板引擎使用twig，更健壮  
　　4、采用模型方式，系统扩展性更强  

