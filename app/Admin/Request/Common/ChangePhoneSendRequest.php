<?php

declare(strict_types=1);

namespace App\Admin\Request\Common;

use Core\Constants\CaptchaType;
use Core\Constants\ContextKey;
use Core\Model\UserAdmin;
use Core\Request\FormRequest;
use Core\Service\Captcha\CaptchaService;
use Hyperf\Context\Context;
use Hyperf\Validation\Rule;

/**
 * 更换手机号 - 验证码发送 - 请求类.
 */
class ChangePhoneSendRequest extends FormRequest
{
    public function rules(): array
    {
        $uid = Context::get(ContextKey::UID);

        return [
            'phone' => ['bail', 'required', 'string', 'mobile',
                Rule::unique(UserAdmin::table(), 'phone')->ignore($uid, 'user_id'),
                function ($attribute, $value, $fail) {
                    if (make(CaptchaService::class)->canRenewGenCode((string) $value, CaptchaType::CHANGE_PHONE)) {
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
