<?php

/**
 * 定时任务配置文件
 * @author aLoNe.Adams.K <alone@alonetech.com>
 * @date 2020-02-28
 * 秒 分 时 日 月 星期几
 * crontab 格式 * *  *  *  * *    => ["类"]
 */

return [
    /**
     * 配置信息类型，1从配置文件读取，2从数据库读取
     */
    'config_type' => 1,
    /**
     * 队列类型，1使用redis的list，2使用rabbitmq consume，3使用rabbitmq get
     */
    'queue_type' => 1,
    //当使用RabbitMQ的时候，读取以下的配置
    // 队列名称
    'queue_name' => 'alocms.queue.crontask',
    // 交换机名称
    'exchange_name' => 'alocms.exchange.crontask',
    // 消息发送方式
    'type' => 'direct',
    // 路由名称
    'route_name' => 'alocms.route.crontask',
    // tag名称
    'tag_name' => 'alocms.tag.crontask',
    'crontab' => [
        '* * * * * *' => [
            '\\alocms\\console\\cron\\CronTest', //文件清理
        ],
    ],
];
