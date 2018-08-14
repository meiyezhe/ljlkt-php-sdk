<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 15:42
 */

require __DIR__ . '/../vendor/autoload.php';

Ljlkt\LjlktException\HandleException::init();

throw new Exception('参数错误');