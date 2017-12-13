<?php
namespace OAuth\App\Web\Controllers;

use OAuth\App\Controller;

/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/20
 * Time: 12:06
 */
class ResourceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试Token控制器
     * @return string
     */
    function resource()
    {
        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            $this->server->getResponse()->send();
            die;
        }

        //获取用户id
        $token = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());
        //echo "User ID associated with this token is {$token['user_id']}";

        echo json_encode(array('success' => true, 'userid'=>$token['user_id'],'message' => 'You accessed my APIs!'));
    }
}