<?php
namespace Cache\App\Web\Model;

use Cache\Storage\Redis;

/**
 * OAuth2.0 授权令牌数据
 *
 * User: Liu xiaoquan
 * Date: 2017/4/17
 * Time: 10:52
 */
class OAuth2Model extends Redis
{
    function __construct($databases=0)
    {
        parent::__construct($databases);

        //上线时可把此配置删除，直接用父类里的
        $this->master       = $this->DB()->redis('master_test', $databases);
        $this->slave        = $this->DB()->redis('slave_test', $databases);
    }


    function QuerToken( $flag='' )
    {
        $data = $this->slave->get( $flag );

        return $data;
    }

    function DelToken( $flag='' )
    {
        return $this->master->del( $flag );
    }

    function ExistsKey( $flag='' )
    {
        return $this->slave->exists( $flag );
    }

    function SaveToken( $flag='', $json='', $expire=0 )
    {
        $this->master->set( $flag, $json );
        return $this->master->expire( $flag, $expire );
    }
}