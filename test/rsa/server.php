<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */

require __DIR__ . '/../../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Auth\Rsa;
use Ljlkt\Utils\Request;

HandleException::init();

$params = $_POST;

$rsa = new Rsa();
print_r((new Request())->header());
print_r($_SERVER);
print_r($params);die;
$data = $rsa->Validate($params);
print_r($data);
die;