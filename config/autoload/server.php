<?php

declare(strict_types=1);

use Hyperf\Server\Event;
use Hyperf\Server\Server;
use Swoole\Constant;

return [
    'mode' => SWOOLE_PROCESS,
    'servers' => [
        [
            'name' => 'http',
            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => (int) env('APP_PORT', 9501),
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
            ],
        ],
    ],
    'settings' => [
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_WORKER_NUM => env('APP_ENV', 'dev') === 'dev' ? 1 : swoole_cpu_num(), // Worker 进程数
        Constant::OPTION_PID_FILE => BASE_PATH . '/runtime/hyperf.pid',
        Constant::OPTION_OPEN_TCP_NODELAY => true,
        Constant::OPTION_MAX_COROUTINE => 100000,
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true,
        Constant::OPTION_MAX_REQUEST => 100000,
        Constant::OPTION_SOCKET_BUFFER_SIZE => 2 * 1024 * 1024,
        Constant::OPTION_BUFFER_OUTPUT_SIZE => 2 * 1024 * 1024,

        /*
         * 静态资源 - 配置.
         * @see https://hyperf.wiki/3.0/#/zh-cn/filesystem?id=%e9%85%8d%e7%bd%ae%e9%9d%99%e6%80%81%e8%b5%84%e6%ba%90
         */
        // Constant::OPTION_DOCUMENT_ROOT => BASE_PATH . '/public', // 静态资源目录
        // Constant::OPTION_ENABLE_STATIC_HANDLER => true,          // 是否启用静态资源
    ],
    'callbacks' => [
        Event::ON_WORKER_START => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [Hyperf\Framework\Bootstrap\PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT => [Hyperf\Framework\Bootstrap\WorkerExitCallback::class, 'onWorkerExit'],
    ],
];
