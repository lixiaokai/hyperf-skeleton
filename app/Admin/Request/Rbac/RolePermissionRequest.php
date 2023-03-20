<?php

namespace App\Admin\Request\Rbac;

use Core\Constants\Status;
use Core\Model\Permission;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 角色管理 - 设置权限 - 请求类.
 */
class RolePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'permissionIds' => ['bail', 'array'],
            'permissionIds.*' => ['bail', 'integer', Rule::exists(Permission::table(), 'id')],
        ];
    }

    public function attributes(): array
    {
        return [
            'permissionIds' => '权限',
            'permissionIds.*' => '权限',
        ];
    }
}
