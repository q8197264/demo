<?php
namespace OAuth\App\Web\Controllers;

use OAuth\App\Controller;
/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/20
 * Time: 12:06
 */
class AuthorizeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //var_dump($this->storage);
    }

    /**
     * 登陆授权
     */
    public function authorize()
    {
        $request = \OAuth2\Request::createFromGlobals();
        $response = new \OAuth2\Response();

        // configure your available scopes
        $this->scopes();
        //echo '<pre>';print_r($request->query);exit;

        // validate the authorize request
        if (!$this->server->validateAuthorizeRequest($request, $response )) {
            $response->send();
            die;
        }

        // display an authorization form
        if (empty($_POST['authorized'])) {
//            $html = <<<EOF
//            <form method="post">
//              <label>Do You Authorize TestClient?</label><br />
//              <input type="text" name="userid" value="" placeholder='UserId'></input>
//              <input type="submit" name="authorized" value="yes">
//              <input type="submit" name="authorized" value="no">
//            </form>
//EOF;
//            exit($html);
            //单点登陆页
            header("Location:http://open.yaofang.cn/sso/client?redirect_uri={$_GET['redirect_uri']}");
            exit();
        }

        // print the authorization code if the user has authorized your client
        $is_authorized = ($_POST['authorized'] === 'yes');//此处必需加密验证,以判断来自sso的认证

        // A value on your server that identifies the user
        $userid = empty($_POST['userid']) ? '' : $_POST['userid'];
        $this->server->handleAuthorizeRequest($request, $response, $is_authorized, $userid);
        if ($is_authorized) {
            // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
            $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);

            //得到 code 凭证
            echo json_encode(array('code' => $code, 'redirect_uri' => isset($_GET['redirect_uri']) ? $_GET['redirect_uri'] : ''));
            exit();
//            exit("SUCCESS! Authorization Code: $code");
        }
    }

    /**
     * 用户接口范围
     */
    private  function scopes()
    {
        $defaultScope = 'basic';
        $supportedScopes = array(
            'basic',
            'userinfo'
        );
        $scopes = isset($_REQUEST['scope']) && ($scopes=$_REQUEST['scope']) ? explode( ' ', $scopes ) : array();
        $supportedScopes = array_intersect( $scopes, $supportedScopes );
        $memory = new \OAuth2\Storage\Memory(array(
                                                'default_scope' => $defaultScope,
                                                'supported_scopes' => $supportedScopes
                                            ));
        $scopeUtil = new \OAuth2\Scope($memory);
        $this->server->setScopeUtil($scopeUtil);
    }
}