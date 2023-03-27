<?php

declare(strict_types=1);

namespace App\Admin\Request\Rbac;

use Core\Constants\Status;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 角色管理 - 创建|修改 - 请求类.
 */
class RoleRequest extends FormRequest
{
    public const SCENE_UPDATE = 'update';

    protected array $scenes = [
        // 说明：parent_id 创建后不能修改
        self::SCENE_UPDATE => ['name', 'remark', 'status', 'sort'],
    ];

    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:20'],
            'remark' => ['bail', 'string', 'max:250'],
            'status' => ['bail', 'required', 'string', Rule::in(Status::codes())],
            'sort' => ['bail', 'required', 'integer', 'between:0,99'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '名称',
            'remark' => '备注',
            'status' => '状态',
            'sort' => '排序',
        ];
    }
}
