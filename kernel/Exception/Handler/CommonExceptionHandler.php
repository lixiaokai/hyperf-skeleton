<?php

declare(strict_types=1);

namespace Kernel\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\Codec\Json;
use Kernel\Exception\BaseException;
use Kernel\Exception\DataSaveException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * 公共 - 异常处理器.
 */
class CommonExceptionHandler extends ExceptionHandler
{
    protected LoggerInterface $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->get('Exception');
    }

    /**
     * @param BaseException $throwable
     */
    public function handle(\Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        // 阻止异常冒泡
        $this->stopPropagation();

        // 记录日志
        $this->log($throwable);

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(200)
            ->withBody(new SwooleStream(
                // 格式化输出
                Json::encode([
                    'code' => $throwable->getCode(),
                    'message' => $throwable->getMessage(),
                ])
            ));
    }

    public function isValid(\Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }

    /**
     * 记录 - 日志.
     */
    private function log(\Throwable $throwable): void
    {
        $message = sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile());

        switch (true) {
            case $throwable instanceof DataSaveException:
                $this->logger->error($message);
                $this->logger->error($throwable->getTraceAsString());
                break;
            default:
                $this->logger->warning($message);
        }
    }
}
