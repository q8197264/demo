<?php
namespace OAuth\Core;
/**
 * 框架配置
 * User: 刘孝全
 * Date: 2016/2/23
 * Time: 11:42
 */
header('Content-Type:text/html;charset=utf-8');
ini_set('display_errors',1);error_reporting(E_ALL);
date_default_timezone_set('PRC') OR ini_set('date.timezone','Asia/Shanghai');

$_ENV['COMPONENT_ROOT'] = str_replace('\\','/',dirname(dirname(__DIR__)).'/component.yaofang.cn');

//加载日志类
if ( is_file($_ENV['COMPONENT_ROOT'].'/log/cy_log.php') ){
    require_once($_ENV['COMPONENT_ROOT'].'/log/cy_log.php');
}

//自动加载类
require_once(__DIR__.'/AutoLoader.php');
\OAuth\Core\AutoLoader::Register();

//加载公共方法类
require_once(dirname( __DIR__ ) . '/Config/Config.php');
include(dirname( __DIR__ ) . '/Common/Utils.php');
include(dirname( __DIR__ ) . '/Common/Http.php');

//uri router
\OAuth\Core\Router::Run();

