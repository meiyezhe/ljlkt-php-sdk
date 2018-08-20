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
    'width' => '65',//画布宽度
    'height' => '30',//画布高度
    'bgcolor' => '#EEF7FE',//背景颜色
    'color' => '#546F50',//字体颜色
    'fecolor' => '#346FA1',//干扰点颜色
    'hotcolor' => '#30137D',//噪点颜色
    'fontsize' => '20',
    'str' => '',//字符串
];

$conf = array_filter($config);

return $conf;

