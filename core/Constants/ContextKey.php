<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 上下文 Key - 常量.
 *
 * @method static string getText(string $code)
 */
#[Constants]
class ContextKey extends AbstractConstants
{
    /**
     * 用户 UID.
     */
    public const UID = 'uid';

    /**
     * 用户模型.
     */
    public const USER = 'user';

    /**
     * 总后台用户模型.
     */
    public const USER_ADMIN = 'userAdmin';

    /**
     * 租户 ID.
     */
    public const TENANT_ID = 'tenantId';

    /**
     * 应用 ID.
     */
    public const APP_ID = 'appId';
}
