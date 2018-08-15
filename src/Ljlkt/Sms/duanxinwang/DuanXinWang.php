<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/8/13
 * Time: 11:16
 * 短信网(http://www.duanxinwang.cc/html/apidocs.html)
 * # 发送模板短信
 * public function tpl($config)
 *
 *
 */

namespace Ljlkt\Sms\duanxinwang;

use Ljlkt\Sms\INotes;

class DuanXinWang implements INotes
{
    //短信配置文件
    private static $config;

    public function __construct()
    {
        self::$config = require __DIR__ . '/config/app.php';
        //参数
    }

    /*
     *初始化配置
     */
    public function config($config = [])
    {
        $config = array_filter($config);
        self::$config = array_filter(array_merge(self::$config, $config));
    }

    /*
     *发送模板短信
     */
    public function tpl($config = [])
    {
        //选择模板
        $config = TextTemplate::check($config);
        //非法校验
        $config = $this->validateConfig($config);

        $flag = 0;
        $params = '';
        foreach ($config as $key => $value) {
            if ($flag != 0) {
                $params .= "&";
                $flag = 1;
            }
            $params .= $key . "=";
            $params .= urlencode($value);// urlencode($value);
        }
        $url = "http://" . $params; //提交的url地址
//        $con = substr(file_get_contents($url), 0, 1);  //获取信息发送后的状态
        return $config;
    }

    /*
     * 发送视频短信
     */
    public function voice()
    {
        return 'voice';
    }

    /*
     * 配置参数校验
     */
    protected function validateConfig($config)
    {
        $data = array_filter(array_merge(self::$config, $config));
        if (empty($data['name']) || empty($data['pwd']) || empty($data['content']) || empty($data['mobile']) || empty($data['sign']) || empty($data['type'])) {
            throw new \Exception('参数错误', 100202);
        }
        return $data;
    }
}

/*
 * 短信模板
 */

class TextTemplate
{
    public static function check($config)
    {
        $foo = $config['tpl'];
        if (!method_exists(new TextTemplate(), $foo)) {
            throw new \Exception('短信模板不存在', 100204);
        }
        $config['content'] = TextTemplate::$foo($config['data']);
        unset($config['tpl']);
        unset($config['data']);
        return $config;
    }

    //模板1
    private static function tpl1($data = [])
    {
        if (empty($data['verify'])) {
            throw new \Exception('参数错误', 10020301);
        }
        return '短信验证码为：' . $data['verify'] . '，请勿将验证码提供给他人。';
    }
}

/*
 * 非法校验
 */

class Validate
{

    public static function run()
    {

    }
}