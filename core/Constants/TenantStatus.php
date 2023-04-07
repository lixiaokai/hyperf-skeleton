<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 租户状态 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class TenantStatus extends AbstractConstants
{
    /**
     * @Text("待初始化")
     */
    public const WAIT_INIT = 'waitInit';

    /**
     * @Text("启用")
     */
    public const ENABLE = 'enable';

    /**
     * @Text("禁用")
     */
    public const DISABLE = 'disable';
}
