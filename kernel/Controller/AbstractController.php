<?php

declare(strict_types=1);

namespace Kernel\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 控制器 - 抽象基类.
 */
abstract class AbstractController
{
    #[Inject]
    protected RequestInterface $request;
}
