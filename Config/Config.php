<?php
/**
 * 个性配置
 * User: Liu Xiaoquan
 * Date: 17-4-29
 * Time: 下午4:14
 * To change this template use File | Settings | File Templates.
 */
header('Content-type:text/html;charset=utf-8');

//自动加载 oauth2-server/src 目录下的类
require_once('OAuth2.0/src/OAuth2/Autoloader.php');
\OAuth2\Autoloader::register();

\CY_log::path('/apache/applog/oauth.yaofang.cn/'.__CLASS__);