<?php
require __DIR__ . '/../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Utils\R;
use Ljlkt\Picture\Pic;
HandleException::init();
function initPic(){
    $c = [
        'name'=>'name',
        'pwd'=>'pwd',
        'sign'=>'sign',
        'tpl' => 'tpl1',
        'mobile' => '23423',
        'data' => ['verify' => '2342']
    ];
    $verif = Pic::run('verif');
    $verif->initPic($c);
    return $verif;
}

$config = [
    'width' => '50',//画布宽度
    'height' => '30',//画布高度
    'bgcolor' => '#FDFCF8',//背景颜色
    'color' => '#30137D',//字体颜色
    'fecolor' => '#30137D',//干扰点颜色
    'hotcolor' => '#30137D',//噪点颜色
    'str' => 'he2x',//字符串
];
$pic = initPic();
$pic->verif($config);
