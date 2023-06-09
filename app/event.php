<?php

// 事件定义文件
return [
    'bind' => [],

    'listen' => [
        'AppInit' => [],
        'HttpRun' => [],
        'HttpEnd' => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'Log' => [
            \alocms\event\listener\Log::class,
        ],
    ],

    'subscribe' => [
        \alocms\event\subscribe\Task::class,
    ],
];
