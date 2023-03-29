<?php

declare(strict_types=1);

namespace App\Admin\Request\Common;

use Core\Constants\ContextKey;
use Core\Request\FormRequest;
use Hyperf\Context\Context;

/**
 * 我的 - 修改密码 - 请求类.
 */
class ProfileResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'oldPassword' => ['bail', 'required', 'string', 'min:6', function ($attribute, $value, $fail) {
                $user = Context::get(ContextKey::USER);
                if (! $user->checkPassword($value)) {
                    $fail('旧密码不正确，请重新输入');
                }
            }],
            // different 新密码不能和旧密码相同
            'password' => ['bail', 'required', 'string', 'min:6', 'different:oldPassword'],
            'confirmPassword' => ['bail', 'required', 'same:password'],
        ];
    }

    public function attributes(): array
    {
        return [
            'oldPassword' => '旧密码',
            'password' => '新密码',
            'confirmPassword' => '确认密码',
        ];
    }
}
