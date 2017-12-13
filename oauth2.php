<?php
require_once(__DIR__ . '/Core/Config.php');

use OAuth\Exception\OAuthException;

/**
 * OAuth2.0 授权验证系统
 * User: Liu xiaoquan
 * Date: 2016/12/8
 * Time: 18:50
 */
class oauth2
{
    /**
     * 接口验证 （是否同一企业）避免其它企业抓取本公司接口
     * 开放接口授权验证
     */
    function __construct()
    {
        $this->Core = new OAuth\Core\Core('Web');
    }

    function index()
    {
        echo 'SUCCESS! Authorization Code: '.$code = isset($_GET['code']) ? $_GET['code'] : '';
        $redirect_uri = isset($_GET['redirect_uri'])?$_GET['redirect_uri']:'http://oauth.yaofang.cn/oauth2/index';
        echo <<<EOF
            <html>
                <body>
                    <!-- 测试Token控制器 -->
                    <form action="http://oauth.yaofang.cn/oauth2/Token" method="post" enctype="application/x-www-form-urlencode">
                        <input type="text" name="client_id" value="" placeholder="client_id"></input>
                        <input type="text" name="client_secret" value="" placeholder="client_secret"></input>
                        <input type="text" name="grant_type" value="client_credentials" placeholder="grant_type"></input>
                        <input type="submit" value="测试">
                    </form>

                    <form action="http://oauth.yaofang.cn/oauth2/Authorize" method="get"
                    target="_blank"
                    enctype="application/x-www-form-urlencoded">
                     一、<input type="text" name="response_type" value="code"></input>
                        <input type="text" name="client_id" value="" placeholder="client_id"></input>
                        <input type="text" name="state" value="" placeholder="state"></input>
                        <input type="text" name="scope" value="" placeholder="scope"></input>
                        <input type="text" name="redirect_uri" style="width:250px" value="http://oauth.yaofang.cn/oauth2/index"></input>
                        <input type="submit" value="授权">
                    </form>

                    <!-- 测试Token控制器 -->
                    <form name="get_access_token" action="http://oauth.yaofang.cn/oauth2/Token" method="post" target="_blank">
                    二、<input type="text" name="client_id" value="" placeholder="client_id"></input>
                        <input type="text" name="client_secret" value="" placeholder="client_secret"></input>
                        <input type="text" name="grant_type" value="authorization_code"></input>
                        <input type="text" name="code" value="{$code}" placeholder="code"></input>
                        <input type="text" name="redirect_uri" style="width:250px" value="{$redirect_uri}"></input>
                        <input type="submit" value="获取令牌">
                        <input type="button" id="GetAccessToken" value="ajax获取令牌">
                    </form>

                    <form action="http://oauth.yaofang.cn/oauth2/Resource" method="get" target="_blank"
                    enctype="application/x-www-form-urlencoded">
                    三、<input type="text" name="access_token" value="" placeholder="access_token"></input>
                        <input type="submit" value="打开接口">
                    </form>
                </body>
            </html>
            <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
EOF;
        exit;
    }



    /**
     * 登陆授权认证
     * 请在30秒内完成这个操作，因为Authorization Code的有效期只有30秒
     * http://localhost/authorize.php?response_type=code&client_id=testclient&state=xyz
     *
     * @param response_type string    $_GET['response_type']    默认:code
     * @param client_id     string    $_GET['client_id']
     * @param state         string    $_GET['state']
     * @param scope         string    $_GET['scope']
     * @param redirect_uri  string    $_GET['redirect_uri']     回调url
     *                      注：根据商户注册了url个数，验证各有不同:
     *                          1.未注册url:    可传任意url            【必传】
     *                          2.注册了1个url: 必需匹配url或不传此参数 【非必传】
     *                          3.注册了多个：  必需匹配其中之一        【必传】
     *
     * @param oauthorize    string    $_POST['oauthorize']      授权同意
     * @param userid        int       $_POST['userid']         用户 id
     */
    function authorize()
    {
        try {
            $this->Core->AuthorizeController()->authorize();
        } catch (OAuthException $e) {
            echo $e->getMsg();
        }
    }

    /**
     * CURL POST
     *
     * @param client_id          string      $_POST['client_id']
     * @param client_secret      string      $_POST['client_secret']
     * @param client_credentials string      $_POST['client_credentials']
     *
     * response message array
     */
    public function token()
    {
        try {
            $this->Core->TokenController()->token();
        } catch (OAuthException $e) {
            echo $e->getMsg();
        }
    }

    /**
     * 令牌验证
     *
     * @param access_token string    $_GET['access_token']
     *
     */
    public function resource()
    {
        try {
            $this->Core->ResourceController()->resource();
        } catch (OAuthException $e) {
            echo $e->getMsg();
        }
    }
}

