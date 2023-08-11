<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'redis'),

    // 缓存连接方式配置
    'stores'  => [
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // 更多的缓存连接
        'redis' => [

            // 数据库类型
            'type'            => env('cache.type', '\alocms\extend\think\cache\driver\RedisCluster'),
            // 服务器地址
            'host'        => env('cache.host', '127.0.0.1'),
            // 数据库名
            'select'        => env('cache.select', 0),
            // 密码
            'password'        => env('cache.password', ''),
            // 端口
            'port'        => env('cache.port', 6379),
            // 数据库表前缀
            'prefix'          => env('cache.prefix', 'alocms:'),

            'timeout' => 5,
            'expire' => 0,
            'persistent' => request()->isCli(),
            'tag_prefix' => 'tag:',
            'serialize' => [],
            'cluster' => false, //是否开启集群模式
        ]
    ],
];
