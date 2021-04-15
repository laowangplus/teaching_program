<?php


namespace App\Http\Service\curl;

const Key = "58695454209710489704371";
const DcsApiUrl = "http://dcsapi.com/?";

class RequestService{
    public static function PostFile($url, $file_path){
        $post_data = array(
            'file' => '@'.$file_path,
        );
        $header = array(
            'Accept: application/form-data',
        );
        var_dump($post_data);
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL , $url);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch , CURLOPT_POST, 1);
        // 设置请求头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch , CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function DcsApi($file_path){
        $output = file_get_contents(DcsApiUrl."k=".Key."&url=".$file_path);
        return $output;
    }
}