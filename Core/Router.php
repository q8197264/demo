<?php
namespace OAuth\Core;

/**
 * url路由
 * User: 刘孝全
 * Date: 2016/6/29
 * Time: 16:41
 */
class Router
{
    protected static $urlPath;
    protected static $query=array();
    protected static $class;
    protected static $method;
    protected static $params=array();

    /**
     * 运行
     */
    static function Run()
    {
        //例：http://component.yaofang.cn/allpay/cy_allpay.php?m=pay&out_trade_no=123223421&total_fee=1&pay_id=1
        self::parseUrl();

        //经过url重写：目录模式
        if (strpos(self::$urlPath,'.php')===false) {
            self::getRedirectQuery();
        }else{
            //未经过url重写：参数模式
            self::getOriginUriQuery();
        }
        self::getMethodParameters();
    }

    /**
     * 获取请求方法参数
     */
    private static function getMethodParameters()
    {
        self::deleteReuestMethod($_REQUEST,self::$method);
        self::deleteReuestMethod($_GET,self::$method);

        if (isset(self::$class)){
            if (is_callable(array(self::$class,self::$method))){

                //参数排序
                $access = new \ReflectionClass(self::$class);
                $args = $access->getMethod(self::$method)->getParameters();
                $args = array_flip(array_map(create_function('$v','return $v->name;'),$args));
                if ( !empty($args) && !empty(self::$params) ){
                    if( $inter = array_intersect_key($args,self::$params)) {
                        self::$params = array_merge($args,self::$params);
                    }
                }

                call_user_func_array(array(new self::$class,self::$method),self::$params);
            }else{
                trigger_error('Router error >> '.self::$class.'::'.self::$method.'() is not callable!',E_USER_ERROR);
            }
        }else{
            trigger_error('url error : The class file is not exists!',E_USER_ERROR);
        }
    }

    //url解析
    private static function parseUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        count($url)>1 AND parse_str(end($url),self::$query);
        self::$urlPath = trim($url['path'],'/');
    }

    //经过url重写：目录模式
    protected static function getRedirectQuery()
    {
        //http://component.yaofang.cn/allpay/cy_allpay/pay?out_trade_no=123223421&total_fee=1&pay_id=1&getPayUrl=1
        $ex = explode('/',self::$urlPath);
        self::$class = ($class = array_shift($ex))=='oauth2.0'?'server':$class;
        self::$method = array_shift($ex);

        $_params=array();
        array_walk(self::$query,function($v,$k)use(&$_params){
            if(!preg_match('/[\/\\\]/',$k)) {
                $_params[$k]=$v;
            }
        });

        self::$params = empty($_params)?( empty($ex)?array():(count($ex)>0?$ex:array_shift($ex)) ):array_merge($ex,$_params);
    }

    //未经过url重写：参数模式
    protected static function getOriginUriQuery()
    {
        self::$urlPath = strrchr(self::$urlPath,'/') ? strrchr(self::$urlPath,'/') : self::$urlPath;
        self::$class = ltrim(rtrim(self::$urlPath,'.php'),'/');
        self::$method = array_shift(self::$query);
        self::$params=self::$query;
    }


    /**
     * 从请求中获取出受访问的方法 (...xx.com?m={$method}) ，并把它从请求中剔除
     * @param array $array
     * @param string $m
     */
    private static function deleteReuestMethod( &$array=array(), $m='' )
    {
        list($k,$v)=each($array);
        reset($array);
        if ($k=='m' && $v==$m){
            array_shift($array);
        }
    }
}