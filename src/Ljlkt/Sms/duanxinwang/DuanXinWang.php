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
use Ljlkt\Utils\R;

class DuanXinWang implements INotes
{
    const HOST = 'http://web.duanxinwang.cc/asmx/smsservice.aspx';

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
    public function initSms($config = [])
    {
        $config = array_filter($config);
        self::$config = array_filter(array_merge(self::$config, $config));
    }

    /*
     *发送模板短信
     */
    public function tpl($config = [])
    {
        //合并参数
        $config = $this->mergeConfig($config);
        //选择模板
        $config = TextTemplate::check($config);
        //非法校验
        $this->validateConfig($config);

        $response = $this->curl($config);

        $data = explode("\r\n", $response);
        $response = $data[count($data) - 1];
        $response = explode(",", $response);
        if ($response[0] != 0) {
            throw new \Exception($response[1]);
        }
        return [];
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
        if (empty($config['name']) || empty($config['pwd']) || empty($config['content']) || empty($config['mobile']) || empty($config['sign']) || empty($config['type'])) {
            throw new \Exception('参数错误', 100202);
        }
        return true;
    }

    /*
     * 合并参数
     */
    protected function mergeConfig($config)
    {
        $data = array_filter(array_merge(self::$config, $config));
        return $data;
    }

    private function curl($postData = [])
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, self::HOST);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
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