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
$str=substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYabcdefghijkmnprstuvwxy345678'),0,4);
$config = [
    'width' => '130',//画布宽度
    'height' => '60',//画布高度
    'bgcolor' => '#EEF7FE',//背景颜色
    'color' => '#546F50',//字体颜色
    'fecolor' => '#346FA1',//干扰点颜色
    'hotcolor' => '#30137D',//噪点颜色
    'str' => $str,//字符串
    'fontsize' => '40',//字体大小
];
$pic = initPic();
echo "<img src='".$pic->verif($config)."' >";
