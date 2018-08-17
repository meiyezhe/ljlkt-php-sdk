<?php
/**
 * Created by PhpStorm.
 * User: Lpeng
 * Date: 2018/8/14
 * Time: 9:25
 * 顶层异常处理
 */

namespace Ljlkt\Exception;

use Ljlkt\Utils\R;

class HandleException
{
    //配置
    public static function init()
    {
        set_exception_handler('Ljlkt\Exception\HandleException::httpException');
    }

    //处理
    public static function httpException($e)
    {
        $code = $e->getCode() == 0 ? 500 : $e->getCode();
        echo R::response($code, $e->getMessage());
    }
}