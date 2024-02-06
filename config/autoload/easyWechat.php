<?php

declare(strict_types=1);

/**
 * 微信 - 相关配置.
 *
 * @see https://easywechat.com/5.x/official-account/configuration.html 公众号配置
 *
 * 日志配置
 * level: 日志级别, 可选为：debug/info/notice/warning/error/critical/alert/emergency
 * path: 日志文件位置 ( 绝对路径!!! )，要求可写权限
 */
use function Hyperf\Support\env;

$_wechatConfig = [
    // 资源返回类型：array(default)/collection/object/raw/自定义类名
    'response_type' => 'array',
    // 日志配置
    'log' => [
        'default' => env('APP_ENV', 'dev'), // 默认使用的 channel，生产环境可以改为下面的 prod
        'channels' => [
            // 测试环境
            'dev' => [
                'driver' => 'single',
                'path' => BASE_PATH . '/runtime/logs/easyWechat.log',
                'level' => 'debug',
            ],
            // 生产环境
            'prod' => [
                'driver' => 'daily',
                'path' => BASE_PATH . '/runtime/logs/easyWechat.log',
                'level' => 'info',
            ],
        ],
    ],
];

return [
    // 微信公众号
    'officialAccount' => [
        'default' => [
            'app_id' => env('APP_ENV', 'dev') === 'dev' ? env('WECHAT_OA_SANDBOX_APP_ID') : env('WECHAT_OA_APP_ID'),
            'secret' => env('APP_ENV', 'dev') === 'dev' ? env('WECHAT_OA_SANDBOX_APP_SECRET') : env('WECHAT_OA_APP_SECRET'),
        ] + $_wechatConfig,
    ],
    // 企业微信
    'work' => [
        'default' => $_wechatConfig + [
            // 我的企业 -> 企业信息 -> 企业 ID
            'corp_id' => env('WECHAT_WORK_CORP_ID', ''),

            'agent_id' => '3010040',
            'secret' => 'Vk6uY0ifvLQJu6ZtP8Aqxf0kZDOd-oZjzTxCUAhJY9Y',

            'token' => 'koXmihNQ1dBCdKsnPNzfmzNig3',
            'aes_key' => '4HH18w5SknWP8yiCNxSn7BoEa8JsOfjGOOhMPTA6OUe',
        ],
        'approval' => $_wechatConfig + [],
    ],
    // 企业微信 - 群机器人
    'workGroup' => [
        'enable' => true, // 是否启用
        'default' => [
            'groupKey' => env('WECHAT_WORK_DEFAULT_GROUP_KEY', ''), // 企业微信群机器人 Key
            'mention' => env('WECHAT_WORK_DEFAULT_MENTION'), // 默认 @某人
        ],
    ],
];
