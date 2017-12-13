<?php
namespace Cache\App;

use Cache\App\Model;
use Cache\Exception\CacheException;

/**
 * 公共业务区
 *
 *      应用场景：放一些公用的业务逻辑
 *
 * User: Liu xiaoquan
 * Date: 2017/4/17
 * Time: 11:16
 */
class Controller
{
    protected static $prefixs;//解析后的前缀
    private static $Model;

    /**
     * 解析配置
     * @param array $configKey
     */
    public function __construct($configKey=array())
    {
        self::buildKey($configKey);
    }

    /**
     * 解析config 配置的键值对 映射关系
     * @param $configKey
     */
    private static function buildKey($configKey)
    {
        foreach ($configKey as $k => $v) {
            list($key,$database) = explode('@',$k);
            self::$prefixs[$key][$v] = $database;
        }

    }

    /**
     * 连接数据访问类
     * @param int $database
     *
     * @return mixed
     */
    protected function Model($database=0)
    {
        if (empty(self::$Model[$database])) {
            self::$Model[$database] = new Model($database);
        }

        return self::$Model[$database];
    }


    /**
     *  为键key 做拼接或加密
     *
     * @param string $prefix        键的前缀
     * @param string $prestr        要存储的数据
     * @param string $callback      回调函数，作用于键的前缀 $prefix     （可传入自定义的处理函数或内置函数）
     *
     * @return array
     * @throws CacheException
     */
    protected function getKey($prefix='', $prestr='', $callback='')
    {
        reset(self::$prefixs[$prefix]);
        list($prefix, $databases) = each(self::$prefixs[$prefix]);
        if (!empty($callback)) {
            if (is_callable($callback)) {
                $prestr = call_user_func_array($callback,array($prestr));
            } else {
                throw new CacheException('无法调用此方法或函数');
            }
        }

        $redisKey = $prefix.':'.$prestr;

        return array($databases=>$redisKey);
    }
}