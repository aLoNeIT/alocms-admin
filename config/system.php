<?php

/**
 * 服务器系统相关配置
 */
return [
    /**
     * 服务器名称，不同服务器名称不一致
     * 需要注意的是生产部署时候，每个服务器都要设置不一样
     */
    'server_name' => env('server_name', 'alocms'),
    //项目名称
    'project_name' => env('system.project_name', 'alocms'),
    // 代理服务器地址，用于request->ip()识别代理服务器
    'proxy_server' => env('system.proxy_server', '127.0.0.1,::1'),
    // ip白名单，多个ip用逗号分隔
    'ip_white_list' => env('system.ip_white_list', '0.0.0.0'),
    // 令牌配置信息
    'token' => [
        'expires_in' => 86400, //access_token有效时间，秒
        'refresh_expires_in' => 86200, //refresh_token有效时间，秒，要小于expires_in
    ],
];
