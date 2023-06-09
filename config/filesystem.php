<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'public'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => env('filesystem.disk_local_root', \runtime_path('storage'))
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => \env('filesystem.disk_public_root', \public_path('uploads')),
            // 磁盘路径对应的外部URL路径
            'url'        => \env('filesystem.disk_public_url', '/uploads'),
            // 可见性
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
    ],
];
