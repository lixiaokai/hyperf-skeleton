<?php

namespace App\Admin\Request\Public;

use Core\Constants\CaptchaType;
use Core\Request\FormRequest;
use Core\Service\Captcha\CaptchaService;

/**
 * 验证码发送 - 请求类.
 */
class SmsLoginSendRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['bail', 'required', 'string', 'mobile', 'exists:user_admin,phone', function ($attribute, $value, $fail) {
                if (make(CaptchaService::class)->canRenewGenCode((string) $value, CaptchaType::LOGIN)) {
                    return true;
                }
                return $fail('1 分钟仅可发送 1 次，请稍后再试');
            }],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => '手机号',
        ];
    }
}
