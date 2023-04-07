<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 验证码类型 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class CaptchaType extends AbstractConstants
{
    /**
     * 验证码类型 - 登录.
     *
     * @Text("登录")
     */
    public const LOGIN = 'login';

    /**
     * 验证码类型 - 验证.
     *
     * @Text("验证")
     */
    public const VERIFY = 'verify';

    /**
     * 验证码类型 - 更换手机号.
     *
     * @Text("更换手机号")
     */
    public const CHANGE_PHONE = 'changePhone';
}
