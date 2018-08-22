<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */

require __DIR__ . '/../../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Auth\Auth;
use Ljlkt\Utils\Request;

HandleException::init();

$config = [
    'redis' => [
        'host' => '118.123.18.164',
        'port' => 8479
    ]
];
$params = [
    'token' => 'sdfdsf',
    'appId' => 0,
    'data' => [
    ]
];
$request = new Request();
$postHeader = $request->header();
$postData = $request->post();
//print_r($postHeader);
//print_r($postData);
$obj = new Auth($postHeader, $postData, $config);
$data = $obj->validate();
echo json_encode([
    'code' => 0,
    'token' => 'sdfdsfsdfdsfsdf',
    'msg' => 'success',
    'data' => $data]);