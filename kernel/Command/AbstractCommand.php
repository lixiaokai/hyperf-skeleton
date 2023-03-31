<?php

declare(strict_types=1);

namespace Kernel\Command;

use Hyperf\Command\Command as HyperfCommand;

/**
 * 命令行 - 抽象基类.
 *
 * 主要是计算耗时和内存使用量.
 */
abstract class AbstractCommand extends HyperfCommand
{
    protected float $startTime;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->_timerStart();
    }

    // 注意：这里不能用析构函数，测试用户会报错
    // public function __destruct()
    // {
    //     $this->_timerStop();
    // }

    /**
     * 定时器 - 开始.
     */
    protected function _timerStart()
    {
        $this->startTime = microtime(true);
    }

    /**
     * 定时器 - 结束.
     */
    protected function _timerStop()
    {
        $endTime = microtime(true);
        $seconds = round($endTime - $this->startTime, 3);
        $memoryUsage = round(memory_get_usage() / 1024 / 1024, 2);

        $this->info("执行完毕 ( 耗时: {$seconds}s | 消耗内存: {$memoryUsage}MB )");
    }
}
