<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Curl
{
    public static function get($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //如果是https访问
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        //执行
        $output = curl_exec($ch);
        //关闭
        curl_close($ch);
        return $output;
    }

    public static function post($url,$postData)
    {
        //初始化
        $ch = curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // post数据
        curl_setopt($ch, CURLOPT_POST,1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
        //如果是https访问
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        //执行
        $output = curl_exec($ch);
        //关闭
        curl_close($ch);
        return $output;
    }
}
?>