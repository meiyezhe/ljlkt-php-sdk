<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */

require __DIR__ . '/../../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Crypt\Rsa;
use Ljlkt\Utils\Curl;

HandleException::init();

$rsa = new RSA();
$data = [1, 2, 34, 5, 6, 7, 8];
$params = [
    'token' => '',
    'appId' => 1,
    'data' => $rsa->encrypt($data)
];

//post请求
$rep = (new Curl())->send('http://sdk.ljlsp.com/rsa/server', $params, 'post');

print_r($rep);
die;