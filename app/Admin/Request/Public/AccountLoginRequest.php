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
            'account' => ['bail', 'required', 'string', 'min:3', 'max:50'],
            'password' => ['bail', 'required', 'min:6'],
        ];
    }

    public function attributes(): array
    {
        return [
            'account' => '账号',
            'password' => '密码',
        ];
    }
}
