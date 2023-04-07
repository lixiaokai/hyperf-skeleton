<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 用户授权类型 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class UserAuthType extends AbstractConstants
{
    /**
     * 用户名、邮箱、手机号登录.
     *
     * @Text("密码登录")
     */
    public const PWD = 'pwd';

    /**
     * @Text("微信登录")
     */
    public const WECHAT = 'wechat';
}
