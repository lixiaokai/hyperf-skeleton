<?php

declare(strict_types=1);

namespace App\Admin\Request\Rbac;

use Core\Request\FormRequest;

/**
 * 权限 - 创建|修改 - 请求类.
 */
class PermissionRequest extends FormRequest
{
    public const SCENE_UPDATE = 'update';

    protected array $scenes = [
        // 修改时需要验证且提交的字段
        self::SCENE_UPDATE => ['parentId', 'name'],
    ];

    public function rules(): array
    {
        return [
            'parentId' => ['bail', 'nullable', 'integer'],
            'route' => ['bail', 'required', 'string', 'max:100'],
            'attachRoutes' => ['bail'],
            'name' => ['bail', 'required', 'string', 'max:100'],
            'desc' => ['bail', 'string', 'max:250'],
            'sort' => ['bail', 'integer', 'max:9999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'parentId' => '父 ID',
            'route' => '路由',
            'attachRoutes' => '附加路由',
            'name' => '名称',
            'desc' => '描述',
            'sort' => '排序',
        ];
    }
}
