<?php

namespace App\Admin\Request\Public;

use Core\Request\FormRequest;

/**
 * 用户登录 - 请求类.
 */
class LoginRequest extends FormRequest
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
