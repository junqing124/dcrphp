<?php


namespace app\Index\Model;

use app\Admin\Model\Admin;
use app\Admin\Model\Factory;
use app\Admin\Model\User;
use dcr\Db;
use dcr\ENV;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Thamaraiselvam\MysqlImport\Import;

class Install
{
    private $sqlFilePath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'sql';

    /**
     * @return string
     */
    public function getSqlFilePath(): string
    {
        return $this->sqlFilePath;
    }

    /**
     * 执行某个目录下的sql文件
     * @param $sqlDirPath
     * @return bool
     * @throws
     */
    public function executeSqlFiles($sqlDirPath)
    {
        ENV::init();
        $host = env('MYSQL_DB_HOST');
        $port = env('MYSQL_DB_PORT');
        $username = env('MYSQL_DB_USERNAME');
        $password = env('MYSQL_DB_PASSWORD');
        $database = env('MYSQL_DB_DATABASE');

        $sqlFileList = scandir($sqlDirPath);
        foreach ($sqlFileList as $sqlFile) {
            if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                $sqlFilename = $sqlDirPath . DS . $sqlFile;
                //echo $sqlFilename;
                //echo '-';
                new Import($sqlFilename, $username, $password, $database, $host . ':' . $port);
            }
        }

        return true;
    }

    public function importDemoData()
    {
        $install = new Install();
        $install->executeSqlFiles($this->sqlFilePath);
        return Admin::commonReturn(1);
    }

    public function install(
        $host,
        $username,
        $password,
        $database,
        $port = 3306,
        $coverData = 1,
        $importDemo = 1,
        $charset = 'utf8'
    ) {

        $lockPath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'lock';
        if (file_exists($lockPath)) {
            throw new \Exception('已经安装过了，如果重新安装，请删除[' . realpath($lockPath) . ']再重新运行本安装程序');
        }

        $envFileExample = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            $data = Env::getData($envFileExample);

            $data['config']['MYSQL_DB_HOST'] = $host;
            $data['config']['MYSQL_DB_PORT'] = $port;
            $data['config']['MYSQL_DB_DATABASE'] = $database;
            $data['config']['MYSQL_DB_USERNAME'] = $username;
            $data['config']['MYSQL_DB_PASSWORD'] = $password;
            $data['config']['MYSQL_DB_CHARSET'] = $charset;
            Env::write($envFile, $data);

            //重新加载配置
            Env::init();
            $container = container();
            $config = $container->make(\dcr\Config::class);
            $config->loadConfig();
            $container->instance(\dcr\Config::class, $config);

            //dd(file_get_contents( $envFile ));

            //用原始的创建
            $conn = mysqli_connect($host, $username, $password, '', $port);
            if (!$conn) {
                throw new \Exception('连接数据库失败');
            }
            if ($coverData) {
                mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}` /*zt_id=1*/");
            } else {
                mysqli_query($conn, "CREATE DATABASE `{$database}` /*zt_id=1*/");
            }

            $install = new Install();
            $install->executeSqlFiles($this->sqlFilePath);

            $sqlFileList = scandir($this->sqlFilePath);
            foreach ($sqlFileList as $sqlFile) {
                if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $tableNameArr = explode('_', pathinfo($sqlFile)['filename']);
                    unset($tableNameArr[0]);
                    $tableName = implode('_', $tableNameArr);
                    $truncateSql = "truncate table {$tableName}/*zt_id=0*/";
                    DB::exec($truncateSql);
                }
            }

            //添加role
            $info = array(
                'name' => '系统管理员',
                'note' => '系统最高权限',
                'zt_id' => session('ztId')
            );

            $user = new User();
            $roleId = $user->addRole($info);

            //初始化user
            $userInfo = array(
                'username' => 'admin',
                'password' => '123456',
                'sex' => 1,
                'mobile' => '15718126135',
                'tel' => '',
                'is_super' => 1,
                'note' => '管理员',
                'zt_id' => 1,
                'roles' => array(1),
            );
            //返回
            $type = 'add';
            $user->addEditUser($userInfo, $type);

            //权限权限配置
            $user->permissionRefresh();

            //给管理员配置全权限
            $permissionList = $user->getPermissionList();
            $permissionIds = implode(',', array_column($permissionList, 'id'));
            DB::update('user_role', array('zt_id' => 1, 'permissions' => $permissionIds,), "name='系统管理员'");

            $sqlDetail = <<<SQL
                INSERT INTO `config` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'site_name','DcrPHP建站系统',1),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'213123','12',1),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'template_name','default',2);
                INSERT INTO `config_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'基本配置',1,'config','base'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板配置',1,'config','template'),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'新闻中心',0,'model','news'),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产品中心',0,'model','product'),(5,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'资料中心',0,'model','info');
                INSERT INTO `config_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'基本配置',1,'config','base'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板配置',1,'config','template'),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'新闻中心',0,'model','news'),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产品中心',0,'model','product'),(5,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'资料中心',0,'model','info');
                INSERT INTO `config_list_item` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'网站名','string','site_name',1,'',1,1),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板名','select','template_name',1,'var.systemTemplateStr',1,2);
                INSERT INTO `config_table_edit_item` VALUES (11,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,1,'string','ID','id',2),(17,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,1,'',0,1,0,'',1,'',0,0,'string','父表ID','ctel_id',2),(18,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'小写英文字母开头，只能小写英文及数字',1,'like',1,1,'string','字段名','db_field_name',2),(19,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',1,1,'string','标题','title',2),(20,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,1,'string','数据类型','data_type',2),(21,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中显示','is_show_list',2),(22,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中能搜索','is_search',2),(23,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','能添加','is_insert',2),(24,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','添加必填','is_insert_required',2),(25,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','能更新','is_update',2),(26,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','更新必填','is_update_required',2),(27,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'编辑页面类型为hidden',1,'',0,0,'checkbox','input hidden','is_input_hidden',2),(28,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'like,like_left,like_right,equal',0,1,0,'',1,'',0,0,'select','搜索类型','search_type',2),(29,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','提示','tip',2),(30,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','默认值','default_str',2),(33,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,0,0,'',0,'',0,1,'string','ID','id',1),(34,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'',1,1,'string','关键字','keyword',1),(35,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','页面标题','page_title',1),(36,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','模块名','page_model',1),(37,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',0,0,'string','表名','table_name',1),(40,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许删除','is_del',1),(41,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许添加','is_add',1),(42,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许编辑','is_edit',1),(43,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','排序','list_order',1),(44,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','where','list_where',1),(45,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的宽以px或%结尾',0,'',0,0,'string','编辑窗口宽','edit_window_width',1),(46,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的高以px或%结尾	',0,'',0,0,'string','编辑窗口高','edit_window_height',1),(47,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'text','操作列自定义额外html','addition_option_html',1),(48,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(',0,'',0,0,'string','允许使用外部变量','allow_config_from_request',1),(50,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加页面form额外的html',0,'',0,0,'text','添加页面form额外的html','add_page_addition_html',1),(51,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'编辑页面form额外的html',0,'',0,0,'text','编辑页面form额外的html','edit_page_addition_html',1),(52,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表里添加按钮拼接html',0,'',0,0,'text','列表添加按钮拼接html','add_button_addition_html',1),(53,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表里编辑按钮拼接html',0,'',0,0,'text','列表里编辑按钮拼接html','edit_button_addition_html',1),(54,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,1,'',0,0,0,'',0,'',0,0,'string','ID','id',3),(55,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,0,0,'',0,'like',1,1,'string','用户名','username',3),(56,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',1,1,'string','电话','mobile',3),(57,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表按钮区额外html',1,'',0,0,'text','列表按钮区额外html','button_area_addition_html',1);
                INSERT INTO `config_table_edit_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'config_table_edit_list','单表管理列表(勿删)','系统配置','config_table_edit_list',1,1,1,'id desc','','95%','95%','<a title=\"字段\" href=\"javascript:;\" onclick=\"open_iframe(\'配置字段\',\'/admin/tools/table-edit-list-view/config_table_edit_item?ctel_id={db.index_id}&list_where=ctel_id={db.index_id}\',\'95%\',\'95%\')\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont Hui-iconfont-menu\"></i></a>','','','','','','<a href=\"javascript:;\" onclick=\"open_iframe(\'自动生成\',\'/admin/tools/table-edit-generate-view\',\'600\',\'400\')\" class=\"btn btn-primary radius\"><i class=\"Hui-iconfont\"></i> 自动生成</a>'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'config_table_edit_item','单表管理字段(勿删)','系统配置','config_table_edit_item',1,1,1,'id desc','','95%','95%','','list_where','<input type=\"hidden\" name=\"ctei_ctel_id\" value=\"{get.ctei_ctel_id}\">','','?ctei_ctel_id={get.ctei_ctel_id}','',''),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'user_mobile','会员手机号(案例)','用户','user',0,0,1,'','','600px','250px','','','','','','','');/*zt_id*/
SQL;

            DB::exec($sqlDetail);

            if ($importDemo) {
                $install->importDemoData();
            }
            //记录已经安装
            file_put_contents($lockPath, date('Y-m-d H:i:s'));

            return Admin::commonReturn(1);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
