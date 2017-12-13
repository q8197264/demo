<?php
namespace OAuth\Storage;

use OAuth\Storage\StrorageInterface;

/**
 * redis 数据库驱动
 * 负责 操作数据库的 CURD
 * User: Liu xiao quan
 * Date: 2016/7/13
 * Time: 11:21
 */
class Redis implements StrorageInterface
{
    private static $db;

    function __construct($databases=0)
    {
        $this->master       = $this->DB()->redis( 'master', $databases );
        $this->slave        = $this->DB()->redis( 'slave', $databases );
    }

    //开启事务
    function trans_begin()
    {
    }

    //事务回滚
    function trans_rollback()
    {
    }

    //提交事务̬
    function trans_commit()
    {
    }

    //数据库驱动连接 DAO 层
    public function DB()
    {
        if ( empty(self::$db) ) {
            require_once($_ENV['COMPONENT_ROOT'].'/DAO/DAO.php');
            self::$db = new \DAO;
        }
        return self::$db;
    }
}