<?php

/**
 * 锁的配置文件
 */
return [
    // 驱动方式
    'type' => 'complex',
    'default' => [
        'type' => 'redis',
    ],
    'redis' => [
        'type' => 'Redis',
        'store' => 'redis', //使用缓存时切换到redis的配置名称
        'expire' => 5, //锁超时时间
    ],
    'file' => [
        'type' => 'File',
        'path' => runtime_path() . '/lock/', //锁存在路径
        'expire' => 5,
    ]
];
