<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/20
 * Time: 10:12
 */

namespace Ljlkt\Utils;


class Curl
{
    private static $url = '';       //访问的URL
    private static $refUrl = '';    // referer url
    private static $data = [];      //数据
    private static $method;         //访问方式 post get
    private static $header = [      // 请求头
        'Content-Type: application/x-www-form-urlencoded'
    ];

    public function send($url, $data = [], $method = 'get')
    {
        if (!$url) {
            throw new \Exception('Curl: url can not be null');
        }
        self::$url = $url;
        self::$method = $method;
        $urlArr = parse_url($url);
        self::$refUrl = $urlArr['scheme'] . '://' . $urlArr['host'];
        self::$data = $data;
        if (!in_array(
            self::$method,
            array('get', 'post', 'put')
        )
        ) {
            throw new \Exception('Curl: error request method type');
        }

        $func = self::$method . 'Request';
        return self::$func(self::$url);
    }

    /*
     * 基础发起curl请求函数
     * @param int $method ['get','post','put']
     */
    private static function doRequest($method = 'get')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        // 来源一定要设置成来自本站
        curl_setopt($ch, CURLOPT_REFERER, self::$refUrl);
        //设置头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_PUT, true);
                break;
            default:
                continue;
                break;
        }
        if (!empty(self::$data)) {
            self::$data = self::dealPostData(self::$data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$data);
        }

        $data = curl_exec($ch);//运行curl
        if(!$data){
            curl_close($ch);
            throw new \Exception('Curl: Request is bad');
        }
        curl_close($ch);
        return $data;
    }

    /*
     * 发起get请求
     */
    public static function getRequest()
    {
        return self::doRequest();
    }

    /**
     * 发起post请求
     */
    public static function postRequest()
    {
        return self::doRequest('post');
    }

    /*
     * 处理发起非get请求的传输数据
     *
     * @param array $postData
     */
    public static function dealPostData($postData)
    {
        if (!is_array($postData)) {
            throw new \Exception('Curl: post data should be array');
        }
        $o = '';
        foreach ($postData as $k => $v) {
            $o .= $k . "=" . urlencode($v) . "&";
        }
        $postData = substr($o, 0, -1);
        return $postData;
    }

    /*
     * 发起put请求
     */
    public static function putRequest()
    {
        return self::doRequest('put');
    }

}