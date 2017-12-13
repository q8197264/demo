<?php
namespace OAuth\Core;

/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/5/12
 * Time: 9:57
 */
class Loader
{
    /**
     * 接口验证 （是否同一企业）避免其它企业抓取本公司接口
     * 开放接口授权验证
     */
    function __construct($domain)
    {
        \CY_log::path('/apache/applog/oauth.yaofang.cn/'.__CLASS__);
        $this->response=null;
        $this->Core = new \OAuth\Core\Core($this->response, $domain);
    }
}