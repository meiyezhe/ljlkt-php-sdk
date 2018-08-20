<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */

require __DIR__ . '/../vendor/autoload.php';

use Ljlkt\Utils\R;
use Ljlkt\Crypt\Rsa;

$rsa = new RSA();
$data = [
    'ret' => 200,
    'code' => 1,
    'data' => array(1, 2, 3, 4, 5, 6),
    'msg' => "success",
];

$ex = json_encode($data);
//加密
$ret_e = $rsa->encrypt($ex);
//解密
$ret_d = $rsa->decrypt($ret_e);
echo $ret_e;
echo '<pre>';
echo $ret_d;

echo '<pre>';