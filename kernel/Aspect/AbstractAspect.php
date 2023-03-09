<?php

namespace Kernel\Aspect;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * 切面 - 抽象基类.
 */
abstract class AbstractAspect extends \Hyperf\Di\Aop\AbstractAspect
{
    protected RequestInterface $request;

    protected LoggerInterface $logger;

    public function __construct(LoggerFactory $loggerFactory, RequestInterface $request)
    {
        $this->logger = $loggerFactory->get('aspect');
        $this->request = $request;
    }
}
