<?php
namespace OAuth\App;

use OAuth\Storage\Mysqli;
use OAuth\Storage\Redis;

/**
 * Created by JetBrains PhpStorm.
 * User: Liu xiaoquan
 * Date: 17-4-29
 * Time: 下午4:16
 * To change this template use File | Settings | File Templates.
 */

class Controller
{
    protected $createReadisDB;
    protected $createMysqliDB;

    public function __construct()
    {
        $storage = $this->redisStorage();

        // Pass a storage object or array of storage objects to the OAuth2 server class
        $this->server = new \OAuth2\Server($storage);

        // Add the "Client Credentials" grant type (it is the simplest of the grant types)
        $this->server->addGrantType(new \OAuth2\GrantType\ClientCredentials($storage));

        // Add the "Authorization Code" grant type (this is where the oauth magic happens)
        $this->server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($storage));

        //$result['data'] = $auth->AuthAccessToken( $args['access_toke'], $args['refresh_token'] );
    }

    public function mysqlStorage()
    {
//        echo '<pre>';
//        var_dump($this->createMysqliDB());
        $dsn      = 'mysql:dbname=oauth_server;host=192.168.10.188;port=3308';
        $username = 'jewim_test_133';
        $password = 'HaveAniceDay133';
        // $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
        $this->storage = $storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
        return $this->storage;
    }

    public function redisStorage()
    {
//        var_dump($this->createReadisDB()->get('oauth_clients:appid'));
        $storage = new \OAuth2\Storage\Redis($this->createReadisDB());
        return $storage;
    }


    //connect Mysql DB
    protected function createMysqliDB()
    {
        if (empty($this->createMysqliDB)) {
            $this->createMysqliDB = new Mysqli();
            $this->createMysqliDB = $this->createMysqliDB->DB()->database('slave',true);
        }
        return $this->createMysqliDB;
    }

    //connect Redis DB
    protected function createReadisDB()
    {
        if (empty($this->createReadisDB)) {
            $this->createReadisDB = new Redis();
            $this->createReadisDB = $this->createReadisDB->DB()->redis('slave_185', 14);
        }
        return $this->createReadisDB;
    }
}