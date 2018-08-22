<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/20
 * Time: 17:43
 */

//默认配置
$config = [
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379
    ]
];

$conf = array_filter($config);

return $conf;