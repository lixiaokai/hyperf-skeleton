<?php

declare(strict_types=1);

namespace App\Admin\Request\Rbac;

use Core\Constants\Status;
use Core\Model\Role;
use Core\Model\UserAdmin;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 总后台用户 - 创建|修改|重置密码 - 请求类.
 */
class UserAdminRequest extends FormRequest
{
    public const SCENE_UPDATE = 'update';

    public const SCENE_RESET_PASSWORD = 'resetPassword';

    protected array $scenes = [
        self::SCENE_UPDATE => ['roleIds', 'name', 'phone', 'status'],
        self::SCENE_RESET_PASSWORD => ['password', 'confirmPassword'],
    ];

    public function rules(): array
    {
        return [
            'roleIds' => ['bail', 'required', 'array'],
            'roleIds.*' => [
                'bail', 'required', 'integer',
                Rule::exists(Role::table(), 'id')->where('status', Status::ENABLE),
            ],
            'name' => ['bail', 'required', 'string', 'max:20'],
            'phone' => [
                'bail', 'required', 'mobile',
                Rule::unique(UserAdmin::table(), 'phone')->ignore($this->route('id')),
            ],
            'password' => ['bail', 'required', 'string', 'min:6'],
            'confirmPassword' => ['bail', 'required', 'same:password'],
            'status' => ['bail', 'string', Rule::in(Status::codes())],
        ];
    }

    public function attributes(): array
    {
        return [
            'roleIds' => '角色',
            'roleIds.*' => '角色 ID',
            'name' => '用户名称',
            'phone' => '手机号',
            'password' => '密码',
            'confirmPassword' => '确认密码',
            'status' => '状态',
        ];
    }
}
