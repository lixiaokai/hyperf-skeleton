<?php

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
}
