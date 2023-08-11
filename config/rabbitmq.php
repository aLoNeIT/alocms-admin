<?php

/**
 * rabbitmq服务器连接信息
 */
return [
    'host' => env('rabbitmq.host', '127.0.0.1'),
    'port' => env('rabbitmq.port', '5672'),
    'user' => env('rabbitmq.user', 'guest'),
    'password' => env('rabbitmq.password', 'guest'),
    'keepalive' => env('rabbitmq.keepalive', true),
    'heartbeat' => env('rabbitmq.heartbeat', 60),
    'vhost' => env('rabbitmq.vhost', 'rabbitmq_vhost'),
    'common_task' => [
        'exchange' => 'alocms.worker.common.task',
        'queue' => 'alocms.worker.common.task',
        'key_route' => 'alocms.worker.common.task',
        'tag_name' => 'alocms.worker.common.task',
        'type' => 'direct'
    ],

];
