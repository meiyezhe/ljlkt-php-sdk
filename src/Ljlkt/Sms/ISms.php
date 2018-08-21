<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/8/13
 * Time: 14:18
 * 短信接口
 */

namespace Ljlkt\Sms;

interface ISms
{
    //初始化配置
    public function initSms();

    //发送模板短信
    public function tpl();

    //发送语音验证码
    public function voice();
}