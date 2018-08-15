<?php
/**
 * Created by PhpStorm.
 * User: Lpeng
 * Date: 2018/8/14
 * Time: 9:25
 * 顶层异常处理
 */

namespace Ljlkt\LjlktException;

use Ljlkt\Utils\R;

class HandleException
{
    //配置
    public static function init()
    {
        set_exception_handler('Ljlkt\LjlktException\HandleException::handle');
    }

    //处理
    public static function handle($e)
    {
        $code = $e->getCode() == 0 ? 500 : $e->getCode();
        echo R::response($e->getMessage(), $code);
    }

    //异常
    public static function excep($msg = '服务器内部错误', $code = 500)
    {
        throw new Exception($msg, $code);
    }
}