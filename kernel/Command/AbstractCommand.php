<?php

declare(strict_types=1);

namespace Kernel\Command;

use Hyperf\Command\Command as HyperfCommand;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * 命令行 - 抽象基类.
 *
 * 主要是计算耗时和内存使用量.
 */
abstract class AbstractCommand extends HyperfCommand
{
    protected Stopwatch $stopwatch;

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
        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start(__CLASS__);
    }

    /**
     * 定时器 - 结束.
     */
    protected function _timerStop()
    {
        $stopwatchEvent = $this->stopwatch->stop(__CLASS__);
        $duration = $stopwatchEvent->getDuration() / 1000; // 执行时间
        $memory = $stopwatchEvent->getMemory() / 1024 / 1024; // 消耗内存

        $this->info("耗时: {$duration} S | 消耗内存: {$memory} MB");
    }
}