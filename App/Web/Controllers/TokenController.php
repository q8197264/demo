<?php
namespace OAuth\App\Web\Controllers;

use OAuth\App\Controller;

/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/20
 * Time: 12:05
 */
class TokenController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试Token控制器
     * @return string
     */
    function token()
    {
        $request = \OAuth2\Request::createFromGlobals();
        //Handle a request for an OAuth2.0 Access Token and send the response to the client
        $response = $this->server->handleTokenRequest($request);
        $response->send();
    }
}