<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */
 
require __DIR__ . '/../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Utils\R;
use Ljlkt\Sms\Sms;

HandleException::init();

function initSms()
{
    $c = [
        'name'=>'name',
        'pwd'=>'pwd',
        'sign'=>'sign',
        'tpl' => 'tpl1',
        'mobile' => '23423',
        'data' => ['verify' => '2342']
    ];
    $sms = Sms::run('duanxinwang');
    $sms->initSms($c);
    return $sms;
}

$config = [
    'tpl' => 'tpl1',
    'mobile' => '23423',
    'data' => ['verify' => '2342'],
];
$sms = initSms();
echo R::ok($sms->tpl($config));