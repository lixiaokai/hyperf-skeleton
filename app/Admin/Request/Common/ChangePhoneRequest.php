<?php

declare(strict_types=1);

namespace App\Admin\Request\Common;

use Core\Constants\ContextKey;
use Core\Model\UserAdmin;
use Core\Request\FormRequest;
use Hyperf\Context\Context;
use Hyperf\Validation\Rule;

/**
 * 更换手机号 - 请求类.
 */
class ChangePhoneRequest extends FormRequest
{
    public function rules(): array
    {
        $uid = Context::get(ContextKey::UID);

        return [
            'phone' => ['bail', 'required', 'string', 'mobile',
                Rule::unique(UserAdmin::table(), 'phone')->ignore($uid),
            ],
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
