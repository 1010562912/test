<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-14
 * Time: 下午1:58
 */

use Server\CoreBase\PortManager;

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_TCP,
    'socket_name' => '0.0.0.0',
    'socket_port' => 8881,
    'pack_tool' => 'LenJsonPack',
    'route_tool' => 'NormalRoute',
    'middlewares' => ['MonitorMiddleware']
];

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_HTTP,
    'socket_name' => '0.0.0.0',
    'socket_port' => 8888,
    'route_tool' => 'NormalRoute',
    'middlewares' => ['MonitorMiddleware', 'NormalHttpMiddleware'],
    'method_prefix' => 'http_',
    'package_max_length'=>1024 * 1024 * 1024*10,
];

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_WS,
    'socket_name' => '0.0.0.0',
    'socket_port' => 8882,
    'route_tool' => 'NormalRoute',
    'pack_tool' => 'NonJsonPack',
    'opcode' => PortManager::WEBSOCKET_OPCODE_TEXT,
    'middlewares' => ['MonitorMiddleware', 'NormalHttpMiddleware'],
    'socket_ssl'=> true,
    'ssl_cert_file' => '/basenv/server/nginx/conf/cert/web.ycw520.top/1537597466758.pem',
    'ssl_key_file' => '/basenv/server/nginx/conf/cert/web.ycw520.top/1537597466758.key',
];

return $config;