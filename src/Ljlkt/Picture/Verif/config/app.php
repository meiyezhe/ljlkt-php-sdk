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
    'width' => '',//画布宽度
    'height' => '',//画布高度
    'bgcolor' => '',//背景颜色
    'color' => '',//字体颜色
    'fecolor' => '',//干扰点颜色
    'hotcolor' => '',//噪点颜色
    'str' => 'pt',//字符串
];

$conf = array_filter($config);

return $conf;

