<?php

declare(strict_types=1);

namespace Core\Service\Sms;

use Core\Service\AbstractService;
use Core\Service\Captcha\CaptchaService;
use Core\Service\Captcha\CodeResult;
use Core\Service\Sms\Template\CaptchaMessage;

/**
 * 短信验证码 - 工厂类.
 */
class SmsFactory extends AbstractService
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
        return make(CaptchaService::class)->genCode($phone, $type); // 获取验证码
        // make(SmsService::class)->send($phone, new CaptchaMessage($codeResult->code)); // 发送验证码 ( 开发测试可临时注释掉，不发送短信 )
    }
}
