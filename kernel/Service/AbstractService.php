<?php

declare(strict_types=1);

namespace Kernel\Service;

use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

/**
 * 服务 - 抽象基类.
 */
abstract class AbstractService
{
    protected ContainerInterface $container;

    protected LoggerInterface $logger;

    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        // 第 1 个参数对应日志的 name
        // 第 2 个参数对应 config/autoload/logger.php 内的 key
        $this->logger = $container->get(LoggerFactory::class)->get('Service');
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
    }
}
