<?php

declare(strict_types=1);

namespace Core\Command;

use Core\Service\Collector\PermissionsCollector;
use Hyperf\Command\Annotation\Command;

/**
 * 收集路由权限节点 - 命令行.
 */
#[Command]
class CollectPermissionsCommand extends AbstractCommand
{
    private float $startTime;

    public function __construct()
    {
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
    }
}
