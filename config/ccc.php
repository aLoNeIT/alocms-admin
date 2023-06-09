<?php

//本文件只用于演示，并无配置作用
return [
    // 驱动方式
    'default' => 'qcloud',
    'stores' => [
        'qcloud' => [
            'type' => 'QCloud',
            'tel' => [
                'app_id' => \env('ccc.qcloud_appid', ''),
                'secret_id' => \env('ccc.qcloud_secretid', ''),
                'secret_key' => \env('ccc.qcloud_secretkey', ''),
            ],
            'expire' => 864000,
        ],
    ],
];
