<?php
namespace Cache\App\Web\Controller;

use Cache\App\Controller;
use Cache\App\Model;
use Cache\App\Utils as func; //导入公共函数空间
use Cache\App\Web\Model\OAuth2Model;
use Cache\Exception\CacheException;

/**
 * OAuth2.0 授权令牌等处理
 *
 * User: Liu xiaoquan
 * Date: 2017/4/17
 * Time: 10:49
 */
class OAuth2 extends Controller
{
    private static $oauth2Model;

//    protected $prefixs;

    function __construct( $configKey=array() )
    {
        parent::__construct($configKey);
    }

    /**
     * 你的业务代码封装
     * @return mixed
     * @throws CacheException
     */
    function getToken( $username='' )
    {
        $userKey = $this->getTokenKey('user_token',$username);
        list($databases, $userKey) = each($userKey);

        $token = $this->oauth2Model($databases)->QuerToken( $userKey );

        //判断Token是否有效
        if (empty($token) && $this->oauth2Model($databases)->ExistsKey($userKey)) {
            //值为空,键存在
            $this->oauth2Model($databases)->DelToken( $userKey );

            throw new CacheException('the value is not exists!');
        }else if( !empty(json_decode($token)->error) ) {
            //用户主键不存在
            $this->oauth2Model($databases)->DelToken( $userKey );
            throw new CacheException(json_decode($token)->error_description);
        }
        if (empty($token)){
            throw new CacheException('',2);
        }

        $this->response->setData($token);
    }

    /**
     * 设置token
     *
     * @param string $username
     * @param string $json
     * @param int    $expire
     *
     * @return mixed
     */
    function setToken( $username='', $json='', $expire=0 )
    {
        $userKey = $this->getTokenKey('user_token',$username);
        list($databases, $userKey) = each($userKey);

        $bool = $this->oauth2Model($databases)->SaveToken( $userKey, $json, $expire );
        if (!$bool) {
            throw new CacheException('',1);
        }
    }


    /**
     * 获取指定的数据库 和 键key
     *
     *  前缀以外的变量值用md5加密
     *
     * @param string $prefix        键前缀
     * @param string $prestr        存储数据
     *
     * @return array()               返回数据库号 和 键key
     */
    protected function getTokenKey($prefix='', $prestr='')
    {
        $list = parent::getKey($prefix, $prestr, 'Cache\App\Utils\md5Sign');

        return $list;
    }


    //---------------- 数据访问类
    protected function oauth2Model($database=0)
    {
        if (empty(self::$oauth2Model[$database])) {
            self::$oauth2Model[$database] = new oauth2Model($database);
        }

        return self::$oauth2Model[$database];
    }
}