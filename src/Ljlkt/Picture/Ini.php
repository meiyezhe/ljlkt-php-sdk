<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/8/13
 * Time: 14:18
 * 短信接口
 */

namespace Ljlkt\Picture;

interface Ini
{
    //初始化配置
    public function initPic();

    //生成验证码
    public function verif();

    //生成二维码
    public function qrcode();
}