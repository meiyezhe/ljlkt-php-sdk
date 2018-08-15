<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/14
 * Time: 11:39
 * API数据转换
 * Response：返回json字符串
 */

namespace Ljlkt\Utils;

class R
{
    const CODE = 0;
    const MSG = "success";

    public static function ok($data = [])
    {
        return self::encodeParams([
            'code' => self::CODE,
            'msg' => self::MSG,
            'data' => $data
        ]);
    }

    public static function response($code = 500, $msg = "", $data = [])
    {
        return self::encodeParams([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    private static function encodeParams($data = [])
    {
        return json_encode($data);
    }
}