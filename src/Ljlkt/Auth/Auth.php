<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/20
 * Time: 11:35
 * Rsa
 * 验证 API 数据加解密
 */

namespace Ljlkt\Auth;

use \Ljlkt\Crypt\Rsa;
use Ljlkt\Cache\Redis;

class Auth
{
    //rsa实例对象
    private static $crypt;

    private static $appId;

    private static $appIds;

    private static $pubKey;

    private static $priKey;

    //配置文件
    private static $config;

    private static $headerParams;

    private static $params;

    public function __construct($headerParams = [], $params = [], $configs = [])
    {
        self::$config = require __DIR__ . '/config/app.php';

        self::$headerParams = $headerParams;

        self::$params = $params;

        //初始化配置
        $this->init($configs);

        //客户端appId群
        self::$appIds = [0, 1, 2, 3, 4, 5];
        //验证appId
        $this->_appId();
        //公私钥
        $this->_getKey();
        //构造加解密
        self::$crypt = new Rsa(self::$pubKey, self::$priKey);
    }

    /*
     * 验证客户端发送的api请求是否合法
     */
    public function validate()
    {
        $params = self::$params;
        //解密验证
        if (!empty($params)) {
            $data = self::$crypt->decrypt($params['data']);
            if ($data === false) {
                throw new \Exception('rsa加解密失败');
            }
            return $data;
        }
        return [];
    }

    /*
     *初始化配置
     */
    private function init($config = [])
    {
        $config = array_filter($config);
        self::$config = array_filter(array_merge(self::$config, $config));
    }

    private function _appId()
    {
        $headerParams = self::$headerParams;
        if (!isset($headerParams['appid'])) {
            throw new \Exception('Auth: appId is null');
        }
        if (!in_array($headerParams['appid'], self::$appIds)) {
            throw new \Exception('Auth: not found addId');
        }
        self::$appId = $headerParams['appid'];
        return true;
    }

    private function _getKey()
    {
        $config = self::$config;
        $options = $config['redis'];
        $redis = new Redis($options);
        $pri_key_name = 'ljlkt:sdk:rsa:prikey:' . self::$appId;
        $pub_key_name = 'ljlkt:sdk:rsa:pubkey:' . self::$appId;

        self::$pubKey = $redis->get($pub_key_name);
        self::$priKey = $redis->get($pri_key_name);
    }
}