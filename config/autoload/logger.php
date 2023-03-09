<?php

declare(strict_types=1);

use Kernel\Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

/**
 * 日志 - 配置文件.
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/logger
 */

$_appEnv = env('APP_ENV', 'dev');
$_formatter = [
    'class' => LineFormatter::class,
    'constructor' => [
        'format' => "[%level_name%] [%datetime%] %channel% %message% %context% %extra%\n",
        'dateFormat' => 'Y-m-d H:i:s',
        'allowInlineLineBreaks' => true,
    ],
];

return [
    'default' => [
        'handlers' => [
            // debug 日志
            [
                'class' => StreamHandler::class,
                'constructor' => [
                    'stream' => $_appEnv === 'dev' ? 'php://stdout' : BASE_PATH . '/runtime/logs/hyperf-debug.log',
                    'level' => Logger::DEBUG,
                ],
                'formatter' => $_formatter,
            ],
            // info、waring、notice 日志
            [
                'class' => StreamHandler::class,
                'constructor' => [
                    'stream' => $_appEnv === 'dev' ? 'php://stdout' : BASE_PATH . '/runtime/logs/hyperf.log',
                    'level' => Logger::INFO,
                ],
                'formatter' => $_formatter,
            ],
            // error 日志
            [
                'class' => StreamHandler::class,
                'constructor' => [
                    'stream' => $_appEnv === 'dev' ? 'php://stdout' : BASE_PATH . '/runtime/logs/hyperf-error.log',
                    'level' => Logger::ERROR,
                ],
                'formatter' => $_formatter,
            ],
        ],
    ],
];
