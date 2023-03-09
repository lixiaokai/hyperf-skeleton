<?php

declare(strict_types=1);

namespace Kernel\Monolog\Handler;

use Monolog\Logger;

/**
 * 流日志 - 处理器.
 *
 * 复写：isHandling()
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/logger
 */
class StreamHandler extends \Monolog\Handler\StreamHandler
{
    /**
     * 是否 - 处理日志.
     *
     * 说明：重写该方法，使得 [info、waring、notice] [debug] [error] 级别日志单独存储
     */
    public function isHandling(array $record): bool
    {
        return match ($record['level']) {
            Logger::DEBUG => $record['level'] == $this->level,
            $record['level'] >= Logger::ERROR => $this->level >= Logger::ERROR && $this->level <= Logger::EMERGENCY,
            default => $this->level >= Logger::INFO && $this->level <= Logger::WARNING,
        };
    }
}
