<?php

declare(strict_types=1);

namespace Core\Service\Sms;

use Core\Service\Captcha\CaptchaService;
use Core\Service\Captcha\CodeResult;
use Core\Service\Sms\Template\CaptchaMessage;

/**
 * 短信验证码 - 工厂类.
 */
class SmsFactory
{
    /**
     * 发送 - 验证码.
     *
     * @see CaptchaType::class 验证码类型
     * @param string $phone 手机号
     * @param string $type  验证码类型
     */
    public static function send(string $phone, string $type): CodeResult
    {
        // 1. 获取验证码
        $codeResult = make(CaptchaService::class)->genCode($phone, $type);

        // 2. 发送验证码
        co(fn () => make(SmsService::class)->send($phone, new CaptchaMessage($codeResult->code)));

        return $codeResult;
    }
}
