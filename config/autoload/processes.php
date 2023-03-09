<?php

declare(strict_types=1);

/**
 * 自定义进程 - 配置.
 *
 * 说明：配置方式和注解方式，二选一即可。
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/process 自定义进程
 * @see https://hyperf.wiki/3.0/#/zh-cn/async-queue 异步队列
 */
return [
    // 任务调度器进程
    // Hyperf\Crontab\Process\CrontabDispatcherProcess::class,
    // 异步消费进程
    // Hyperf\AsyncQueue\Process\ConsumerProcess::class,
];
