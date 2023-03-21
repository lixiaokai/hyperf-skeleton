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
    private Stopwatch $stopwatch;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->_timerStart();
    }

    public function __destruct()
    {
        $this->_timerStop();
    }

    /**
     * 定时器 - 开始.
     */
    private function _timerStart()
    {
        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start(__CLASS__);
    }

    /**
     * 定时器 - 结束.
     */
    private function _timerStop()
    {
        $stopwatchEvent = $this->stopwatch->stop(__CLASS__);
        $duration = $stopwatchEvent->getDuration() / 1000; // 执行时间
        $memory = $stopwatchEvent->getMemory() / 1024 / 1024; // 消耗内存
        $this->info("耗时: {$duration}s | 消耗内存: {$memory}MB");
    }
}
