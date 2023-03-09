<?php

declare(strict_types=1);

namespace Kernel\Listener;

use Hyperf\Command\Event\AfterExecute;
use Hyperf\Coordinator\Constants;
use Hyperf\Coordinator\CoordinatorManager;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * 命令行执行后 - 监听器.
 *
 * 说明：
 * 解决当有监听器监听了 Command 的事件，且进行了 AMQP 或者其他多路复用的逻辑后，会导致进程无法退出的问题
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/upgrade/3.0?id=command
 */
#[Listener]
class ResumeExitCoordinatorListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            AfterExecute::class,
        ];
    }

    public function process(object $event): void
    {
        CoordinatorManager::until(Constants::WORKER_EXIT)->resume();
    }
}
