<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:03
 */
namespace Ljlkt\Picture\Verif;
use Ljlkt\Picture\Ini;

class Verif implements Ini {
    //配置文件
    private static $config;
    public function __construct()
    {
        self::$config = require __DIR__ . '/config/app.php';
        //参数
    }


    //初始化配置
    public function initPic($config = []){
        $config = array_filter($config);
        self::$config = array_filter(array_merge(self::$config, $config));
    }
    //验证码
    public function verif($config=[]){
        //合并参数
        $config = $this->mergeConfig($config);
        print_r($config);
        die();
            /*
       步骤：
           1.创建画布
           2.造颜料
           3.填充背景颜色
           4.画干扰点
           5.画噪点
           6.写字符串
           7.输出图片
           8.销毁画布
        */
        //1.创建画布
        $im=imagecreatetruecolor(50, 30);

        //2.造颜料
        $gray = imagecolorallocate($im,30,30,30);
        $red = imagecolorallocate($im,255,0,0);
        $blue = imagecolorallocate($im, 100, 255, 255);

        //3.填充背景颜色
        imagefill($im,0,0,$blue);

        //4.画干扰点
        for ($i=0; $i <4 ; $i++) {
            imageline($im, rand(0,20),0,100,rand(0,60),$red);
        }

        //5.画噪点
        for($i=0;$i<100;$i++){
            imagesetpixel($im,rand(0,50),rand(0,30),$gray);
        }

        //6.写字符串
        $str=substr(str_shuffle('ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'),0,4);
        imagestring($im,5,5,5,$str,$red);

        //7.输出图片
        header('content-type:image/png');
        imagepng($im);

        //8.销毁画布
        imagedestroy($im);
    }
    //二维码
    public function qrcode(){
        return 'qrcode';
    }

    /*
     * 合并参数
     */
    protected function mergeConfig($config)
    {
        $data = array_filter(array_merge(self::$config, $config));
        return $data;
    }
}