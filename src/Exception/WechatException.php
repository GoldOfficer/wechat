<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/6/20
 * Time: 19:51
 */

namespace GoldOfficer\WeChat\Exception;

class WechatException extends \Exception
{
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct('Wechat Exception:' . $message, $code, $previous);
    }
}