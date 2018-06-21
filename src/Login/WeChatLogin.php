<?php
namespace GoldOfficer\WeChat\Login;

use GoldOfficer\WeChat\Core\Config;
use GoldOfficer\WeChat\Exception\WechatException;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/6/20
 * Time: 18:27
 */
class WeChatLogin
{
    private   $grant_type = 'authorization_code';
    protected $config;
    
    /** @var null|Client */
    private static $client = null;
    
    const TOKEN_URI    = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    const USERINFO_URI = 'https://api.weixin.qq.com/sns/userinfo';
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getAccessToken($code)
    {
        $token_url = self::TOKEN_URI
                     . '?appid=' . $this->config->getAppid()
                     . '&secret=' . $this->config->getSecret()
                     . '&code=' . $code . '&grant_type=' . $this->grant_type;
        
        $client = self::getClient();
        try {
            $respone = $client->get($token_url);
            $content = $respone->getBody()->getContents();
            $content = json_decode($content, true);
        } catch (\Exception $e) {
            throw new WechatException($e->getMessage(), $e->getCode(), $e);
        }
        
        if (isset($content['errcode'])) {
            throw new WechatException($content['errmsg'], $content['errcode']);
        }
        
        return $content;
        
    }
    
    public function getUserInfo($access_token, $oppenid)
    {
        $info_url = self::USERINFO_URI . '?access_token=' . $access_token . '&openid=' . $oppenid;
        
        $client = self::getClient();
        try {
            $respone = $client->get($info_url);
            $content = $respone->getBody()->getContents();
            $content = json_decode($content, true);
        } catch (\Exception $e) {
            throw new WechatException($e->getMessage(), $e->getCode(), $e);
        }
        
        if (isset($content['errcode'])) {
            throw new WechatException($content['errmsg'], $content['errcode'], null);
        }
        
        return $content;
    }
    
    /**
     * @return Client|null
     */
    protected static function getClient()
    {
        if (null === self::$client) {
            self::$client = new Client();
        }
        
        return self::$client;
    }
}