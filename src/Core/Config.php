<?php
namespace GoldOfficer\WeChat\Core;

/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/6/20
 * Time: 18:27
 */
class Config implements \JsonSerializable
{
    
    private $appid;
    private $secret;
    
    public function __construct($appid, $secret)
    {
        $this->appid  = $appid;
        $this->secret = $secret;
    }
    
    public function __toArray()
    {
        return [
            'appid'  => $this->getAppid(),
            'secret' => $this->getSecret(),
        ];
    }
    
    function jsonSerialize()
    {
        return $this->__toArray();
    }
    
    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid;
    }
    
    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }
    
}