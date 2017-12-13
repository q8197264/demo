<?php
namespace OAuth\App\Manage\Controllers;

use OAuth\Storage\Redis;
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 17-4-29
 * Time: 下午7:28
 * To change this template use File | Settings | File Templates.
 */

class RegisterController
{
    protected static $enbleAddr = array('127.0.0.1','61.149.46.138');
    protected $createReadisDB;

    public function __construct()
    {
        if (!self::isAllowAccess()) {
            die('Access Refused');
        }
    }

    protected static function isAllowAccess()
    {
        if (in_array(self::getRemoteAddr(), self::$enbleAddr)) {
            return true;
        }
        return false;
    }

    protected static function getRemoteAddr()
    {
        if(getenv('HTTP_CLIENT_IP')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR')) {
            $onlineip = getenv('REMOTE_ADDR');
        } else {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        //echo $onlineip;
        return $onlineip;
    }

    /**
     * 自建：注册APP帐号
     * redis库
     */
    function register()
    {
        // display an authorization form
        if (empty($_POST)) {
            $html = <<<EOF
            <form method="post">
                <label>Register Authorize APP?</label><br />
                client_id:<input type="text" name="client_id" value="" placeholder="client_id"></input><p>
                client_secret:<input type="text" name="client_secret" value="" placeholder="client_secret"></input><p>
                redirect_uri:<input type="text" name="redirect_uri" value="" placeholder="redirect_uri"></input><p>
                grant_type:<input type="text" name="grant_type" value="authorization_code" placeholder="grant_type"></input><p>
                scope:<input type="text" name="scope" value="basic userinfo" placeholder="scope"></input>
                <input type="submit" name="authorized" value="yes">
            </form>
EOF;
            exit($html);
        }

        $bool='';
        if (!empty($_POST)) {
            $client_id     = $_POST['client_id'];
            $client_secret = $_POST['client_secret'];

            //0个注册redirect_uri时client可传任意redirect_uri(不会匹配验证); 1个可不传(传必验), 多个必传（传必验）
            $redirect_uri  = $_POST['redirect_uri'];
            $grant_types   = $_POST['grant_type'];
            $scope         = $_POST['scope'];
            $user_id = '';
            //echo '<pre>';print_r($_POST);exit;
            $bool = $this->redisReg($client_id, $client_secret, $redirect_uri,$grant_types, $scope, $user_id);

        }

        echo $bool?'success':'fail';
    }

    private function redisReg($client_id, $client_secret, $redirect_uri,$grant_types, $scope, $user_id)
    {
        $storage = new \OAuth2\Storage\Redis($this->createReadisDB());
        return $storage->setClientDetails($client_id, $client_secret, $redirect_uri,$grant_types, $scope, $user_id);
    }

    //connect Redis DB
    protected function createReadisDB()
    {
        if (empty($this->createReadisDB)) {
            $this->createReadisDB = new Redis();
            $this->createReadisDB = $this->createReadisDB->DB()->redis('master_185', 14);
        }

        return $this->createReadisDB;
    }
}