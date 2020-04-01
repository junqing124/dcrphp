<?php

use \app\Model\Plugins;

/**
 * 后台菜单配置
 * 本配置主格式可以menu-user为案例
 */
$menu = array(
    'menu-user' => array(
        'icon' => '&#xe60d;', //图标
        'title' => '会员管理', //一级菜单
        'sub' => array(  //子菜单
            array(
                'url' => '/admin/user/list-view', //地址
                'title' => '会员列表', //标题
            ),
            array(
                'url' => '/admin/user/role-view',
                'title' => '角色列表',
            ),
            array(
                'url' => '/admin/user/permission-view',
                'title' => '权限列表',
            ),
        ),
    ),
    'menu-tools' => array(
        'icon' => '&#xe61a;',
        'title' => '系统工具',
        'sub' => array(
            array(
                'url' => '/admin/tools/plugins-installed-view',
                'title' => '插件中心',
            ),
        ),
    ),
    'menu-config' => array(
        'icon' => '&#xe62e;',
        'title' => '系统配置',
        'sub' => array(
            array(
                'url' => '/admin/config/base-view',
                'title' => '基本配置',
            ),
            array(
                'url' => '/admin/config/model-view',
                'title' => '模型配置',
            ),
        ),
    ),
);

//得到插件列表
$clsPlugin = new Plugins();
$listPlugin = $clsPlugin->getInstalledList();
foreach ($listPlugin as $infoPlugin) {
    //dd($infoPlugin);
    $menu['menu-tools']['sub'][] = array(
        'url' => '/admin/tools/enter-plugins-view/' . $infoPlugin['p_name'],
        'title' => $infoPlugin['p_title'],
    );
}
/*dd($menu);
exit;*/
return $menu;