<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 账号类型 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class AccountType extends AbstractConstants
{
    /**
     * @Text("用户名")
     */
    public const USERNAME = 'username';

    /**
     * @Text("邮箱")
     */
    public const EMAIL = 'email';

    /**
     * @Text("手机号")
     */
    public const PHONE = 'phone';
}
