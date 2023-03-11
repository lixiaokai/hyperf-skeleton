<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 角色类型 - 常量.
 *
 * @method static string getText(string $code)
 * @method static string getPlatformKey(string $code) 该 [ 角色类型 ] 所属平台的 Key
 */
#[Constants]
class RoleType extends AbstractConstants
{
    /**
     * @Text("总后台角色")
     * @PlatformKey("admin")
     */
    public const ADMIN = 'admin';

//    /**
//     * @Text("租户默认角色")
//     * @PlatformKey("tenant")
//     */
//    public const TENANT_DEFAULT = 'tenantDefault';
//
//    /**
//     * @Text("租户自定义角色")
//     * @PlatformKey("tenant")
//     */
//    public const TENANT_CUSTOM = 'tenantCustom';
}
