<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-14
 * Time: 下午1:58
 */

//默认访问的页面
$config['http']['index'] = 'index.html';

/**
 * 设置域名和Root之间的映射关系
 */

$config['http']['root'] = [
    'default' =>
        [
            'render' => "server::welcome" //转到模板
        ],
    'web.ycw520.top'=>[
        'root'=>'www',
        'index'=>'webSocket.html'
    ]
];

return $config;
