<?php
namespace OAuth\Core;

use OAuth\Exception\OAuthException;

/**
 * TODO: 核心类
 * 自动分配同名文件类，并实例化
 * User: Liu xiao quan
 * Date: 2016/6/1
 * Time: 16:43
 */
class Core
{
    private $dir;
    private $obj = array();

    private static $isCallClass;

    public function __construct($fork='')
    {
        $this->dir =  strstr(__NAMESPACE__,'\Core',true).'\App\\'.$fork.'\Controllers';
    }

    /**
     * TODO: 调用子模块，自动转接系统
     * 自动调用相应类文件，并反回实例化对象
     * @param      $class   对象名
     * @param null $args    构造函数的参数
     *
     * @return mixed        对象
     * @throws UserExcepti 异常
     */
    public function __call($className, $args=array())
    {
        try{
            self::$isCallClass = $this->dir.'\\'.$className;
            if ( !class_exists(self::$isCallClass)) {
                throw new OAuthException("{$className} no exists");
            }

            if (isset($this->obj[$className])) {
                return $this->obj[$className];
            }

            $this->obj[$className] = call_user_func_array(array($this,'isCalledClass'),$args);

            return $this->obj[$className];
        }catch(OAuthException $e){
            trigger_error($e->getMsg(), E_USER_ERROR);
        }
    }

    /**
     * 实现调用类
     * @param $args
     *
     * @return mixed
     */
    private function isCalledClass($args=array())
    {
        $obj = new self::$isCallClass($args);

        return $obj;
    }
}