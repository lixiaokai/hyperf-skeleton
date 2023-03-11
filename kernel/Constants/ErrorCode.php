<?php

declare(strict_types=1);

namespace Kernel\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 错误代码 - 枚举类.
 */
#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("未登录")
     */
    public const UNAUTHORIZED = 401;

    /**
     * @Message("无权限访问")
     */
    public const FORBIDDEN = 403;

    /**
     * @Message("内部服务器错误")
     */
    public const SERVER_ERROR = 500;
}
