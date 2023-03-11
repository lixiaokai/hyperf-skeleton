<?php

namespace App\Admin\Request\Rbac;

use Core\Constants\Status;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 菜单 - 创建|修改 - 请求类.
 */
class MenuRequest extends FormRequest
{
    public const SCENE_UPDATE = 'update';

    protected array $scenes = [
        // 修改时需要验证且提交的字段
        // self::SCENE_UPDATE => [],
    ];

    public function rules(): array
    {
        return [
            'parentId' => ['bail', 'nullable', 'integer'],
            'path' => ['bail', 'required', 'string', 'max:100'],
            'route' => ['bail', 'required', 'string', 'max:100'],
            'name' => ['bail', 'required', 'string', 'max:20'],
            'desc' => ['bail', 'string', 'max:250'],
            'icon' => ['bail', 'string', 'max:50'],
            'status' => ['bail', 'string', Rule::in(Status::codes())],
            'sort' => ['bail', 'integer', 'max:9999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'parentId' => '父 ID',
            'platform' => '终端平台',
            'path' => '前端路由',
            'route' => '后端路由',
            'name' => '名称',
            'desc' => '描述',
            'icon' => '图标',
            'status' => '状态',
            'sort' => '排序',
        ];
    }
}
