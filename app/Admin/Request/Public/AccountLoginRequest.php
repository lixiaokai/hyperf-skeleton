<?php

namespace App\Admin\Request\Public;

use Core\Request\FormRequest;

/**
 * 账号登录 - 请求类.
 */
class AccountLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['bail', 'required', 'mobile'],
            'password' => ['bail', 'required', 'min:6'],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => '手机号',
            'password' => '密码',
        ];
    }
}
