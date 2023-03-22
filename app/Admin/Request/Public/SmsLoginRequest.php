<?php

namespace App\Admin\Request\Public;

use Core\Request\FormRequest;

/**
 * 验证码登录 - 请求类.
 */
class SmsLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'mobile', 'exists:user_admin,phone'],
            'code' => ['required', 'min:4'],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => '手机号',
            'code' => '验证码',
        ];
    }
}
