<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 角色类型 - 常量.
 *
 * 说明：不是所有终端都有该类型，一般用于某终端有 [ 系统角色 ] 和 [ 自定义角色 ] 时使用
 *
 * @method static string getText(string $code)
 * @method static string getPlatformKey(string $code) 该 [ 角色类型 ] 所属平台的 Key
 */
#[Constants]
class RoleType extends AbstractConstants
{

//    /**
//     * @Text("租户系统角色")
//     * @PlatformKey("tenant")
//     */
//    public const TENANT_DEFAULT = 'system';
//
//    /**
//     * @Text("租户自定义角色")
//     * @PlatformKey("tenant")
//     */
//    public const TENANT_CUSTOM = 'custom';
}
