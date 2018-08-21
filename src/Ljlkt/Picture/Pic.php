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
            case 'verif':
                return new Verif;
                break;
            default:
                throw new \Exception('未发现图片生成方法', 100201);
        }
    }
}