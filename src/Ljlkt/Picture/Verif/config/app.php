<?php
/**
 * Created by PhpStorm.
 * User: Lpeng
 * Date: 2018/8/13
 * Time: 11:13
 * 短信网 - 配置文件(http://www.duanxinwang.cc/html/apidocs.html#section-5)
 */

//默认配置
$config = [
    'name' => '',//必填参数。用户账号
    'pwd' => '',//必填参数。（登陆web平台：基本资料中的接口密码）
    'content' => '',//必填参数。发送内容（1-500 个汉字，建议300字符内）UTF-8编码
    'mobile' => '',//必填参数。手机号码。多个以英文逗号隔开
    'stime' => '',//可选参数。（发送时间，填写时已填写的时间发送，不填时为当前时间发送，秒到）
    'sign' => '',//必填参数。用户签名。（建议联系销售进行后台绑定）
    'type' => 'pt',//必填参数。固定值 pt
    'extno' => ''   //可选参数，（扩展码，用户定义扩展码，只能为数字，如需要扩展不同签名，需要帮扩展的号码和对应的签名报给客服）
];

$conf = array_filter($config);

return $conf;

