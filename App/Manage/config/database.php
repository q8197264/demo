<?php
/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/20
 * Time: 18:04
 */
//主库
$active_group = 'master';
$active_record = false;

$db['master']['hostname'] = "192.168.10.188";
$db['master']['username'] = 'jewim_test_133';
$db['master']['password'] = 'HaveAniceDay133';
$db['master']['database'] = "ecs_yaofang";
$db['master']['dbdriver'] = "mysqli";
$db['master']['dbprefix'] = "";
$db['master']['pconnect'] = FALSE;
$db['master']['db_debug'] = TRUE;
$db['master']['cache_on'] = FALSE;
$db['master']['cachedir'] = "";
$db['master']['char_set'] = "utf8";
$db['master']['dbcollat'] = "utf8_general_ci";
$db['master']['port'] = 3308;
$db['master']['stricton'] = FALSE;

//从库
$active_group = 'slave';
$active_record = false;

$t=3;
if($t==1){
    $db['slave']['hostname'] = "192.168.10.188";
    $db['slave']['username'] = 'jewim_test_133';
    $db['slave']['password'] = 'HaveAniceDay133';
    $db['slave']['database'] = "ecs_yaofang";
    $db['slave']['dbdriver'] = "mysqli";
    $db['slave']['dbprefix'] = "";
    $db['slave']['pconnect'] = FALSE;
    $db['slave']['db_debug'] = TRUE;
    $db['slave']['cache_on'] = FALSE;
    $db['slave']['cachedir'] = "";
    $db['slave']['char_set'] = "utf8";
    $db['slave']['dbcollat'] = "utf8_general_ci";
    $db['slave']['port'] = 3308;
    $db['slave']['stricton'] = FALSE;
}elseif($t==0){
    $db['slave']['hostname'] = "192.168.10.188";
    $db['slave']['username'] = 'jewim_test_133';
    $db['slave']['password'] = "Cheers-every1";
    $db['slave']['database'] = "ecs_yaofang";
    $db['slave']['dbdriver'] = "mysqli";
    $db['slave']['dbprefix'] = "";
    $db['slave']['pconnect'] = FALSE;
    $db['slave']['db_debug'] = TRUE;
    $db['slave']['cache_on'] = FALSE;
    $db['slave']['cachedir'] = "";
    $db['slave']['char_set'] = "utf8";
    $db['slave']['dbcollat'] = "utf8_general_ci";
    $db['slave']['port'] = 3308;
    $db['slave']['stricton'] = FALSE;
}elseif($t==3){
    $db['slave']['hostname'] = "192.168.10.188";
    $db['slave']['username'] = 'jewim_test_133';
    $db['slave']['password'] = 'HaveAniceDay133';
    $db['slave']['database'] = "ecs_yaofang";
    $db['slave']['dbdriver'] = "mysqli";
    $db['slave']['dbprefix'] = "";
    $db['slave']['pconnect'] = FALSE;
    $db['slave']['db_debug'] = TRUE;
    $db['slave']['cache_on'] = FALSE;
    $db['slave']['cachedir'] = "";
    $db['slave']['char_set'] = "utf8";
    $db['slave']['dbcollat'] = "utf8_general_ci";
    $db['slave']['port'] = 3308;
}


$active_group = 'other';
$active_record = false;

$db['other']['hostname'] = "192.168.10.188";
$db['other']['username'] = 'jewim_test_133';
$db['other']['password'] = 'HaveAniceDay133';
$db['other']['database'] = "ecs_yaofang";
$db['other']['dbdriver'] = "mysqli";
$db['other']['dbprefix'] = "";
$db['other']['pconnect'] = FALSE;
$db['other']['db_debug'] = TRUE;
$db['other']['cache_on'] = FALSE;
$db['other']['cachedir'] = "";
$db['other']['char_set'] = "utf8";
$db['other']['dbcollat'] = "utf8_general_ci";
$db['other']['port'] = 3308;
$db['other']['stricton'] = FALSE;

$active_group = 'session_db';
$active_record = false;
$db['session_db']['hostname'] = '192.168.10.188';
$db['session_db']['username'] = 'jewim_test_133';
$db['session_db']['password'] = 'HaveAniceDay133';
$db['session_db']['database'] = 'yf_session';
$db['session_db']['dbdriver'] = 'mysqli';
$db['session_db']['dbprefix'] = '';
$db['session_db']['pconnect'] = TRUE;
$db['session_db']['db_debug'] = TRUE;
$db['session_db']['cache_on'] = FALSE;
$db['session_db']['cachedir'] = '';
$db['session_db']['char_set'] = 'utf8';
$db['session_db']['dbcollat'] = 'utf8_general_ci';
$db['session_db']['swap_pre'] = '';
$db['session_db']['autoinit'] = TRUE;
$db['session_db']['stricton'] = FALSE;
$db['session_db']['port'] = 3308;


$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = "192.168.10.188";
$db['default']['username'] = "jewim_test_133";
$db['default']['password'] = "HaveAniceDay133";
$db['default']['database'] = "ecs_yaofang";
$db['default']['dbdriver'] = "mysqli";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
$db['default']['port'] = "3308";