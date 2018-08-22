<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/20
 * Time: 16:39
 */

require __DIR__ . '/../../vendor/autoload.php';

use Ljlkt\Exception\HandleException;
use Ljlkt\Cache\Redis;

HandleException::init();

$options = [
    'host' => '118.123.18.164',
    'port' => 8479
];
$redis = new Redis($options);

$appId = 1;
$pri_key_name = 'ljlkt:sdk:rsa:prikey:' . $appId;
$pub_key_name = 'ljlkt:sdk:rsa:pubkey:' . $appId;

$pri_key_content = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDZeUXkIq0uNCDLYppk9DxsEZ0RLTmgn6iWOx16+FMux1+5BZYK
01r1fNJC9n5iiHVnNP9O1OD4eu3mYDH8nwThiasBZGUkHx/bIdN5KwJj6U5+d8st
6M2BTAGldkR70jx1mcLDm99VIrW128ipiJbcbjBswIntXQM06TMscShGJwIDAQAB
AoGAEo2FB+Rpb9KkpZVA5LHtYa7S/n8kNm7IfCCI8E+1EP2TTf6LAVtsnBrM+Ud8
Gr3XfjmIOlpw4uHh39B/EzUhvk+Zyz0NtgSgle0FUzGIoV1KEYKYrvgdQpl48X6b
L1Y7LcEj/alGLptp3nwUdn+bxLAc80Fwy0cpU3FRA2vZo7ECQQD9vd/699JqdIp8
tkBkDXmUPJbQXtPWQblY8W/foS5ZXTd4NE8K4aDiPNchA3Yp+3cnvo8H94A5ZxRf
+5/wkk0ZAkEA22jD38p+hD5n+BH+cyxHDnH6HzIJuVc6zDXZNYlX8ENhpdlrThok
0SPYu9NqCXmi6Ty8O25zL2U+3SvLGb5VPwJAARl9ivzf8I4ou3metdBJIpdQn/6J
NHh8cSI6teFg7go1X1P6s7VemRxiYkY9kNkCHy34OLSd3aHQuMnCW6yGoQJAF+I5
oDzMtNyOOMTMrADf40So84hg4poKPnyGHnvK5M6Q7JrUQXY7F8ENMLT8z/c7sqP3
4YhOZZRh2XWQ8EZ1xQJBAIb+23ebUA0HrVlAps6G7nYy11agIsfvxrCt8DGfAT+J
AH2f/YMrTB4mFcHNsT82PEqdUWij3NQvtalHqhw/Vbk=
-----END RSA PRIVATE KEY-----';

$pub_key_content = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDZeUXkIq0uNCDLYppk9DxsEZ0R
LTmgn6iWOx16+FMux1+5BZYK01r1fNJC9n5iiHVnNP9O1OD4eu3mYDH8nwThiasB
ZGUkHx/bIdN5KwJj6U5+d8st6M2BTAGldkR70jx1mcLDm99VIrW128ipiJbcbjBs
wIntXQM06TMscShGJwIDAQAB
-----END PUBLIC KEY-----';

$redis->set($pri_key_name, $pri_key_content);
$redis->set($pub_key_name, $pub_key_content);