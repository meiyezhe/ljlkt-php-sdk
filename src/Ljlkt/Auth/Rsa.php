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

use \Ljlkt\Crypt\Rsa as Crypt;
use Ljlkt\Cache\Redis;

class Rsa
{
    //rsa实例对象
    private static $crypt;

    private static $appId;

    private static $appIds;

    private static $pubKey;

    private static $priKey;

    //配置文件
    private static $config;

    public function __construct($params = [])
    {
        self::$config = require __DIR__ . '/config/app.php';

        //客户端appId群
        self::$appIds = [0, 1, 2, 3, 4, 5];
        //验证appId
        $this->_appId($params);
        //公私钥
        $this->_getKey();
        //构造加解密
        self::$crypt = new Crypt(self::$pubKey, self::$priKey);

        return self::Validate($params);
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
     * 验证客户端发送的api请求是否合法
     */
    public function Validate($params = [])
    {
        //解密验证
        if (!empty($params)) {
            $params['data'] = self::$crypt->decrypt($params['data']);
            if (empty($params['data'])) {
                throw new \Exception('rsa加解密失败');
            }
            return $params;
        }
        return [];
    }

    private function _appId($params = [])
    {
        if (empty($params['appId'])) {
            throw new \Exception('Rsa: addId is not none');
        }
        if (!in_array($params['appId'], self::$appIds)) {
            throw new \Exception('Rsa: not found addId');
        }
        self::$appId = $params['appId'];
        return true;
    }

    private function _getKey()
    {
        $config = self::$config;
        $options = $config['redis'];
        $redis = new Redis($options);
        $pri_key_name = 'ljlkt:rsa:prikey:' . self::$appId;
        $pub_key_name = 'ljlkt:rsa:pubkey:' . self::$appId;

        self::$pubKey = $redis->get($pub_key_name);
        self::$priKey = $redis->get($pri_key_name);
    }
}