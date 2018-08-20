<?php
require __DIR__ . '/../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Picture\Pic;
HandleException::init();
function initPic(){
    $c = [

    ];
    $verif = Pic::run('verif');
    $verif->initPic($c);
    return $verif;
}

$config = [
    'width' => '65',//画布宽度
    'height' => '30',//画布高度
    'bgcolor' => '#EFB301',//背景颜色
    'color' => '#60E558',//字体颜色
    'fecolor' => '#346FA1',//干扰点颜色
    'hotcolor' => '#30137D',//噪点颜色
    'str' => 'dfgh',//字符串
    'fontsize' => '20',//字体大小
];
$pic = initPic();
echo "<img src='".$pic->verif($config)."' >";
