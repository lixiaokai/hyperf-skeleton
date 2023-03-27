<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 角色类型 - 常量.
 *
 * @method static string getText(string $code)
 */
#[Constants]
class RoleType extends AbstractConstants
{
    /**
     * @Text("系统角色")
     */
    public const SYSTEM = 'system';

    /**
     * @Text("自定义角色")
     */
    public const CUSTOM = 'custom';
}
