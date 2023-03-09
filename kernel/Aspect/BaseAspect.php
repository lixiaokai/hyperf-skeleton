<?php

namespace Kernel\Aspect;

use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * 切面 - 抽象基类.
 */
abstract class BaseAspect extends AbstractAspect
{
    protected RequestInterface $request;

    protected LoggerInterface $logger;

    public function __construct(LoggerFactory $loggerFactory, RequestInterface $request)
    {
        $this->logger = $loggerFactory->get('aspect');
        $this->request = $request;
    }
}
