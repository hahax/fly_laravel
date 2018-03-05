<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/24 0024
 * Time: 下午 12:49
 */
// 设置COS所在的区域，对应关系如下：
//     华南  -> gz
//     华东  -> sh
//     华北  -> tj
$location = 'sh';
// 版本号
$version = 'v4.2.3';

return [
    'version' => $version,
    'api_cos_api_end_point' =>  'http://sh.file.myqcloud.com/files/v2/',
    'app_id' => env("QCLOUD_API_ID"),
    'secret_id' => env("QCLOUD_SECRET_ID"),
    'secret_key' => env("QCLOUD_SECRET_KEY"),
    'user_agent' => 'cos-php-sdk-'.$version,
    'time_out' => 180,
    'location' => $location,
];