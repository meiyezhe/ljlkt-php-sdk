<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/8/13
 * Time: 14:26
 */

namespace Ljlkt\Picture;

use Ljlkt\Picture\Verif\Verif;

class Pic
{
    public static function run($type)
    {
        switch ($type) {
            case 'duanxinwang':
                return new DuanXinWang();
                break;
            default:
                throw new \Exception('短信平台不存在', 100201);
        }
    }
}