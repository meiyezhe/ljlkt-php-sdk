<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:03
 */
namespace Ljlkt\Picture\Verif;
use Ljlkt\Picture\Ini;
use Ljlkt\Picture\Color;

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
        $im=imagecreatetruecolor($config['width'], $config['height']);
        //2.造颜料
        //1)十六进制转rgb
        if(empty($config['fecolor'])){
            $config['fecolor'] = $config['color'];
        }
        if(empty($config['hotcolor'])){
            $config['hotcolor'] = $config['color'];
        }
        $col = new Color;
        $font_color = $col->hex2rgb($config['color']);
        $fe_color = $col->hex2rgb($config['fecolor']);
        $bg_color = $col->hex2rgb($config['bgcolor']);
        $hot_color = $col->hex2rgb($config['hotcolor']);

        $fontcolor = imagecolorallocate($im,$font_color['r'],$font_color['g'],$font_color['b']);
        $fecolor = imagecolorallocate($im,$fe_color['r'],$fe_color['g'],$fe_color['b']);
        $bgcolor = imagecolorallocate($im, $bg_color['r'],$bg_color['g'],$bg_color['b']);
        $hotcolor = imagecolorallocate($im,$hot_color['r'],$hot_color['g'],$hot_color['b']);

        //3.填充背景颜色
        imagefill($im,0,0,$bgcolor);
        // 画边框
//        imagerectangle($im,0,0,$config['width'],$config['width'],$fecolor);

        //4.画干扰点
        for ($i=0; $i <5 ; $i++) {
            imageline($im, rand(0,$config['width']),rand(0,$config['height']),rand(0,$config['width']),rand(0,$config['height']), $fecolor);
        }
        //5.画噪点
        for($i=0;$i<$config['width']*2;$i++){
            imagesetpixel($im,rand(0,$config['width']),rand(0,$config['height']),$hotcolor);
        }

        //6.写字符串
//        $str=substr(str_shuffle('ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'),0,4);
        //imagestring($im,5,10,10,$config['str'],$fontcolor);

        @imagefttext($im, $config['fontsize'] , 0, $config['width']*0.05, $config['height']*0.8, $fontcolor,dirname(__DIR__).'/font/zz.TTF' /*'D:\project\ljlkt\ljlkt-php-sdk\src\Ljlkt\Picture\font\jdxyj.TTF'*/,$config['str']);
        //7.输出图片
//        header('content-type:image/png');
//        imagepng($im);
        //下面是图片转base64返回
        ob_start ();
        imagepng ($im);
        $image_data = ob_get_contents ();
        ob_end_clean ();
        //得到这个结果，可以直接用于前端的img标签显示
        $image_data_base64 = "data:image/png;base64,". base64_encode ($image_data);
        //8.销毁画布
        imagedestroy($im);
        return $image_data_base64;
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
