<?php
/**
 * Created by PhpStorm.
 * User: lpeng
 * Date: 2018/8/16
 * Time: 16:06
 *
 */

namespace Ljlkt\Crypt;


class RSA
{
    private $pubKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBwrycIEl9dzF2FmHFHOYdGuIW
fFb9TG80cerkoEQwgp3Zi7INuBAu9C6UQyRsuW0CxBv/kiJRO87bJdgNjIknA43K
/FSB67A1nH/YqTj1zojfOuhT9+cTONSAiD48o5CTIjgD1CeYCKU5hJ91YprfHm0e
GEcKohhgSjk3aT4+rwIDAQAB
-----END PUBLIC KEY-----';
    private $priKey = '-----BEGIN ENCRYPTED PRIVATE KEY-----
MIICxjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI93mCqiHHVRkCAggA
MBQGCCqGSIb3DQMHBAiVlNTMsj57JgSCAoDu4gfOtn4gUYwmIs2vCHMLlsDlX1wN
K019J4fxaTozxesbTT6d4c+Ju/JvJPgFi9IXtoJVHRjJXEtDfFJaFmYro+gC9Wts
VwVdHiP35/tPQQ9nIV4uhkSOIHTT7KW/1DFdfezXQs6fhV6+cAhYlQqQ7kFWRWEV
+P1/X+rQfYoTFcoph96VUie96BkmGUPLBNvXWDNgsHP4Ny2owEr2TlSoi+WWBttR
HgSLcYOn1omuCUbtZzES/VfGYP6NbLInNsQ3OYaJvUiM60cPuAwGeBtt7W7z/YwC
KnqyF4hVJz1ddhYJgfsnOi3x7EUHPDRlr+2vV6asp+mD38J/JV0vt7WwohZlKPn1
1HcRlK4MyYKiQ6vh3Z2R4nlq/BwGShrWQiq7yT8/U66iLRdOK+9TcS5BhrrV/x1y
x9bMAyW9Xf6YAkrqSeJ4i60wiuzeciKHPc7WaK1pg0K7Yu7W3SqAxC8Y7dWCHDwq
jP1qvRQrC+bA3p2IWu7YHIVe2DKwuLxbj1ki+J753GgSwQN7klflZi2O3SXLrB9g
NALdsZhutBSIY5dBXOncG2n2QnB5lPU+31XXP+HC0bdh+CzjBjj7Nu3uSeJLCBWZ
7AQPbJni5UlvHC2MWdHQCvba4EFyHqH3VXmQROZpFM4Sbx4rK5MVuX9erE67SQgs
qLhcA/+rwwg85xIfa3DAn/ahYRF9PLK+kZaErJm+wahT6lxHo7VsW0QJfhYUW1sI
LBCttvUrKioRqfML8l7aXtVPrc166PYoXHthEqleIOD613zyTZquMYm+PJXcGc4d
asmbpr6AtyZGd/iOW+zpQ1dE2ObpI6/BTN+q3M22l0zBo9m0X7OS0s9w
-----END ENCRYPTED PRIVATE KEY-----
';

    /**
     * 构造函数
     *
     * @param string 公钥文件（验签和加密时传入）
     * @param string 私钥文件（签名和解密时传入）
     */
    public function __construct($public_key_file = __DIR__ . '/rsa/id_rsa.pub', $private_key_file = __DIR__ . '/rsa/id_rsa')
    {
        if ($public_key_file) {
//            $this->_getPublicKey($public_key_file);
        }
        if ($private_key_file) {
//            $this->_getPrivateKey($private_key_file);
        }
    }

    // 私有方法

    /**
     * 自定义错误处理
     */
    private function _error($msg)
    {
        die('RSA Error:' . $msg); //TODO
    }

    /**
     * 检测填充类型
     * 加密只支持PKCS1_PADDING
     * 解密支持PKCS1_PADDING和NO_PADDING
     *
     * @param int 填充模式
     * @param string 加密en/解密de
     * @return bool
     */
    private function _checkPadding($padding, $type)
    {
        if ($type == 'en') {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        } else {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                case OPENSSL_NO_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        }
        return $ret;
    }

    private function _encode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_encode('' . $data);
                break;
            case 'hex':
                $data = bin2hex($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

    private function _decode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_decode($data);
                break;
            case 'hex':
                $data = $this->_hex2bin($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

    private function _getPublicKey($file)
    {
        $key_content = $this->_readFile($file);
        if ($key_content) {
//            $this->pubKey = $key_content;
            $this->pubKey = openssl_get_publickey($key_content);
        }
    }

    private function _getPrivateKey($file)
    {
        $key_content = $this->_readFile($file);
        if ($key_content) {
//            $this->priKey = $key_content;
            $this->priKey = openssl_get_privatekey($key_content);
        }
    }

    private function _readFile($file)
    {
        $ret = false;
        if (!file_exists($file)) {
            $this->_error("The file {$file} is not exists");
        } else {
            $ret = file_get_contents($file);
        }
        return $ret;
    }

    private function _hex2bin($hex = false)
    {
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
        return $ret;
    }

    /**
     * 生成签名
     *
     * @param string 签名材料
     * @param string 签名编码（base64/hex/bin）
     * @return 签名值
     */
    public function sign($data, $code = 'base64')
    {
        $ret = false;
        if (openssl_sign($data, $ret, $this->priKey)) {
            $ret = $this->_encode($ret, $code);
        }
        return $ret;
    }

    /**
     * 验证签名
     *
     * @param string 签名材料
     * @param string 签名值
     * @param string 签名编码（base64/hex/bin）
     * @return bool
     */
    public function verify($data, $sign, $code = 'base64')
    {
        $ret = false;
        $sign = $this->_decode($sign, $code);
        if ($sign !== false) {
            switch (openssl_verify($data, $sign, $this->pubKey)) {
                case 1:
                    $ret = true;
                    break;
                case 0:
                case -1:
                default:
                    $ret = false;
            }
        }
        return $ret;
    }

    /**
     * 加密
     *
     * @param string 明文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return string 密文
     */
    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING)
    {
        openssl_public_encrypt($data, $resultEn, $this->pubKey, $padding);
        openssl_private_decrypt($resultEn, $resultDe, $this->priKey, $padding);
        print_r($resultEn);
        print_r($resultDe);
        die;
        $ret = false;
        if (!$this->_checkPadding($padding, 'en')) $this->_error('padding error');
        if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)) {
            $ret = $this->_encode($result, $code);
        }
        return $ret;
    }

    /**
     * 解密
     *
     * @param string 密文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return string 明文
     */
    public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false)
    {
        $ret = false;
        $data = $this->_decode($data, $code);
        if (!$this->_checkPadding($padding, 'de')) $this->_error('padding error');
        if ($data !== false) {
            if (openssl_private_decrypt($data, $result, $this->priKey, $padding)) {
                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
            }
        }
        return $ret;
    }
}
