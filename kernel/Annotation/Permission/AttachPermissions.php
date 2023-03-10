<?php

declare(strict_types=1);

namespace Kernel\Annotation\Permission;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 附加权限路由 - 注解.
 */
#[Attribute(Attribute::TARGET_METHOD)]
class AttachPermissions extends AbstractAnnotation
{
    /**
     * 路由.
     *
     * 例: GET:/user/{id}
     */
    public array|string $routes;
}
