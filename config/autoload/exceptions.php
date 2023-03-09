<?php

declare(strict_types=1);

/**
 * 异常处理器 - 配置.
 *
 * 注意：每个异常处理器配置的顺序决定了异常在处理器间传递的顺序
 * @see https://hyperf.wiki/3.0/#/zh-cn/exception-handler
 */
return [
    'handler' => [
        // 这里的 http 对应 config/autoload/server.php 中 server 所对应的 name 值
        'http' => [
            \Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class, // Http - 异常处理器
            \Kernel\Exception\Handler\ValidationExceptionHandler::class,      // 验证 - 异常处理器
            \Kernel\Exception\Handler\CommonExceptionHandler::class,          // 公共 - 自定义异常处理器
            \Kernel\Exception\Handler\AppExceptionHandler::class,             // 托底 - 异常处理器
        ],
    ],
];
