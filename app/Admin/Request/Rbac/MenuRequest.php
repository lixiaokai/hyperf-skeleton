<?php

declare(strict_types=1);

namespace App\Admin\Request\Rbac;

use Core\Constants\Status;
use Core\Model\Menu;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;
use Hyperf\Validation\Rules\Exists;

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
            'parentId' => ['bail', 'integer', $this->parentIdExists()],
            'path' => ['bail', 'required', 'string', 'max:100'],
            'route' => ['bail', 'string', 'max:100', $this->routeExists()],
            'name' => ['bail', 'required', 'string', 'max:20'],
            'desc' => ['bail', 'string', 'max:250'],
            'icon' => ['bail', 'string', 'max:50'],
            'status' => ['bail', 'required', 'string', Rule::in(Status::codes())],
            'sort' => ['bail', 'integer', 'between:0,9999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'parentId' => '上级菜单',
            'path' => '前端路由',
            'route' => '后端路由',
            'name' => '名称',
            'desc' => '描述',
            'icon' => '图标',
            'status' => '状态',
            'sort' => '排序',
        ];
    }

    protected function parentIdExists(): ?Exists
    {
        $parentId = $this->input('parentId');
        if ($parentId > 0) {
            return Rule::exists(Menu::table(), 'id')->where('status', Status::ENABLE);
        }

        return null;
    }

    protected function routeExists(): ?Exists
    {
        $route = $this->input('route');

        // 有值时才验证
        if ($route) {
            return Rule::exists(Menu::table(), 'id')->where('status', Status::ENABLE);
        }

        return null;
    }
}
