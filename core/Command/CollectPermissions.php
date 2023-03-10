<?php

declare(strict_types=1);

namespace Core\Command;

use Core\Service\Collector\PermissionsCollector;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;

/**
 * 收集路由权限节点 - 命令行.
 */
#[Command]
class CollectPermissions extends HyperfCommand
{
    private float $startTime;

    public function __construct()
    {
        $this->runTimeStart();

        parent::__construct('collect:permissions');
    }

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('收集路由权限节点, 可随意重复执行');
    }

    public function handle(): void
    {
        make(PermissionsCollector::class)->handle();

        $this->runTimeEnd();
    }

    protected function runTimeStart(): void
    {
        $this->startTime = microtime(true);
    }

    protected function runTimeEnd(): void
    {
        $endTime = microtime(true);
        $seconds = round($endTime - $this->startTime, 3);
        $memoryUsage = round(memory_get_usage() / 1024 / 1024, 2);

        $this->info("执行完毕 ( 耗时: {$seconds}s | 消耗内存: {$memoryUsage}MB )");
    }
}
