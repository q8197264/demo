<?php
//获取当前目录 并加载配置文件
require_once(__DIR__ . '/Core/Config.php');

use OAuth\Exception\OAuthException;

/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/19
 * Time: 12:22
 */
class manage
{
    /**
     * 接口验证 （是否同一企业）避免其它企业抓取本公司接口
     * 开放接口授权验证
     */
    function __construct()
    {
        $this->Core = new OAuth\Core\Core('Manage');
    }

    /**
     * 自建：注册APP帐号
     * redis库
     *
     * @param client_id     string    $_POST['client_id']
     * @param client_secret string    $_POST['client_secret']
     * @param scope         string    $_POST['scope']
     * @param grant_types   string    $_POST['grant_types']
     * @param redirect_uri  string    $_POST['redirect_uri']     回调url,多个时以空格分隔
     * 注：根据商户注册url个数，验证各有不同:
     *                          1.未注册url:    获取授权时不验证url，必传
     *                          2.注册了1个url: 获取授权时参数必需匹配url或不传此参数，非必传
     *                          3.注册了多个：  获取授权时参数必需匹配其中之一，必传
     */
    function registerMerchant()
    {
        // display an authorization form
        try {
            $this->Core->RegisterController()->register();
        } catch (OAuthException $e) {
            echo $e->getMsg();
        }
    }



    //     /**
    //      *   自建，后台
    //      **/
    //    function userCredentials()
    //    {
    //        // create some users in memory
    //        $users = array('123' => array('password' => '123123', 'first_name' => 'a', 'last_name' => 'b'));
    //
    //        // create a storage object
    //        $storage = new OAuth2\Storage\Memory(array('user_credentials' => $users));
    //
    //        // create the grant type
    //        $grantType = new OAuth2\GrantType\UserCredentials($storage);
    //
    //        // add the grant type to your OAuth server
    //        $this->server->addGrantType($grantType);
    //    }
}