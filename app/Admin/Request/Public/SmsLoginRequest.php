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
            'phone' => ['bail', 'required', 'string', 'mobile', 'exists:user_admin,phone'],
            'code' => ['bail', 'required', 'string', 'min:4'],
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
