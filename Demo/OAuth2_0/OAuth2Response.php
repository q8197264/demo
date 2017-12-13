<?php
namespace Cache\App;

/**
 * TODO:接口最终结果响应类
 * 最终数据通过处理，再予以返回
 * User: Liu xiaoquan
 * Date: 2017/3/22
 * Time: 15:43
 */
class OAuth2Response
{
    //错误码 与 对应的文字描述             【需自定义配置】
    private static $errCode = array(
        0=>'success',
        1=>'fail',
        2=>'没有找到相关数据',
        3=>'无法调用此方法或函数',
    );

    //设置属于正确码的索引                    【可自定义配置】
    // 【区别在于返回的结果中，信息描术的属性为 正确:msg 错误:err_msg】
    private static $rightScope = array(0);


    protected $response = array();

    function __construct( $errCode=NULL ){
        if (!empty($errCode)) {
            self::$errCode = $errCode;
        }
    }

    /**
     * 返回最终响应结果
     * @return array|null
     */
    function Send()
    {
        empty($this->response['return_code']) AND $this->SetReturnCode(0);
        $response = $this->response;
        unset($this->response);

        return $response;
    }

    /**
     * 设置状态码：用于判断结果，附带自动匹配相应的错误信息
     * @param $code
     */
    function setReturnCode( $code=0 )
    {
        $this->response['return_code'] = $code;

        if ( !in_array($code,array_keys(self::$errCode))){
            exit("WARNING:the errCode {$code} is no set!");
        }
        if ( in_array( $code, self::$rightScope) ){
            $this->response['msg'] = self::$errCode[$code];
        }else{
            $this->response['err_msg'] = self::$errCode[$code];
        }
    }

    /**
     * 自定义响应结果参数设置
     * @param $key
     * @param $val
     */
    function setParamter( $key, $val )
    {
        if ( 'return_code'!=$key && ('data'!=$key)) {
            $this->response[$key] = $val;
        }
    }

    /**
     * 设置响应结果数组
     * @param $response
     */
    function setData( $response )
    {
        $this->response['data'] = $response;
    }

    /**
     * 错误结果信息或提示
     * @param string $errMsg
     */
    function setErrMsg( $errMsg='' )
    {
        unset($this->response['msg']);
        empty($this->response['return_code']) AND $this->SetReturnCode(1);
        $this->response['Describe'] = $errMsg;
    }

    /**
     * 错误出现的文件，显示所在代码行
     * @param $error
     */
    function setErrPath( $error )
    {
        empty($this->response['return_code']) AND $this->SetReturnCode(1);
        $this->response['err_file'] = $error;
    }

    /**
     * 错误跟踪 (仅跟踪本接口内文件))
     * @param string $str
     */
    function setErrTrace( $str='' )
    {
        $pattern = '/'.preg_quote(__NAMESPACE__,'/').'/';
        $str= implode(array_reverse(preg_grep($pattern,explode('#',$str)),'\n\r'));
        $this->response['err_trace'] = $str;
    }
    function getSend()
    {
        return $this->response;
    }

    //连贯访问方式的防错机制
    function __call( $method, $args ){
        $method = lcfirst($method);
        if (method_exists($this, $method)) {
            $this->$method($args);
        }else{
            exit("WARNING:the {$method} is no exists!");
        }
    }
}