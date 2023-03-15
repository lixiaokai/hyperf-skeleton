<?php

declare(strict_types=1);

namespace Kernel\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Kernel\Exception\Format\ExceptionMessage;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 托底 - 异常处理器.
 *
 * 说明：该异常处理器务必放在 config/autoload/exceptions.php 配置的最后，起到拖底的作用
 */
class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        // 阻止异常冒泡
        $this->stopPropagation();

        // 记录日志
        $this->log($throwable);

        return $response
            ->withHeader('Server', 'Hyperf')
            ->withStatus(500)
            ->withBody(new SwooleStream('Internal Server Error.'));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    /**
     * 记录 - 日志.
     */
    private function log(Throwable $t): void
    {
        $this->logger->error(ExceptionMessage::format($t));
        $this->logger->error($t->getTraceAsString());
    }
}
