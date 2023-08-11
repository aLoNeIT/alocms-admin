<?php

//文件上传组件配置文件
return [
    'default' => \env('filestorage.default', 'huawei'),
    'global' => [ // 全局配置
        'host' => env('filestorage.host', ''), // 文件域名，生成url时候需要
        'size' => \env('filestorage.size', 5242880), //上传文件限制大小 单位字节
        'ext' => \env('filestorage.ext', 'jpg,png,gif,bmp,jpeg,doc,docx,xls,xlsx,webp,apkwmv,asf,asx,rm,rmvb,mp4,3gp,mov,m4v,avi,dat,mkv,flv,vob,zip,rar,7z,tar,pdf'), //上传文件后缀
        'content_type' => [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'xml' => 'application/xml',
            'mp4' => 'audio/mp4',
        ],
        'disk' => [ //文件上传保存路径
            'public' => [
                'path' => \env('filestorage.disk_public', \public_path('uploads')),
                'visibility' => 'public', // 可见性，只有public和private两种，public代表公开，private代表私有需要权限，默认为public
            ],
            'private' => [
                'path' => \env('filestorage.disk_private', \root_path('private/uploads')),
                'visibility' => 'private',
            ],
            'default' => \env('filestorage.disk_default', 'public'), // 默认使用磁盘
        ],
        //临时目录，用于驱动执行时生成临时文件的路径
        'runtime_path' => \env('filestorage.runtime_path', \runtime_path('filestorage')),
        'disk_separator' => \env('filestorage.disk_separator', ':'),
    ],
    'stores' => [
        'local' => [ // 不配置则表示走全局配置
            'type' => 'Local',
            'depth' => 2, //文件目录深度
            'access' => 0755, // 创建的目录权限
            'api' => 'home/v1/file/local', // 本地文件处理接口地址，可和host拼接成有效地址，需要应用层实现该接口
        ],
        'think' => [
            'type' => 'Think',
            'depth' => 2, //文件目录深度
            'access' => 0755, // 创建的目录权限
            'disk' => [
                'default' => 'public',
                'public' => [ // think驱动的key，代表Filesystem下的驱动名
                    'path' => 'public' // path，代表Filesystem下的磁盘名
                ]
            ]
        ],
        'huawei' => [
            'type' => 'Huawei',
            'access_key' => env('filestorage.huawei_ak', ''), // ak
            'secret_key' => env('filestorage.huawei_sk', ''), // sk
            'endpoint' => env('filestorage.huawei_endpoint', 'obs.cn-east-3.myhuaweicloud.com'), // 接口地址
            'host' => env('filestorage.huawei_host', ''), // 如果有配置绑定域名（非null），则使用该值代替endpoint，末尾无需/
            'bucket' => env('filestorage.huawei_bucket', ''), // 桶名
            'socket_timeout' => 30, // socket超时时间
            'connect_timeout' => 3, // 连接超时时间
            'signature' => 'obs',
            'disk' => [
                'default' => 'public',
                'public' => [
                    'path' => 'public',
                ],
                'private' => [
                    'path' => 'private',
                    'visibility' => 'private',
                ],
                'sms' => [
                    'path' => 'sms',
                    'visibility' => 'private',
                ]
            ]
        ],
    ]
];
