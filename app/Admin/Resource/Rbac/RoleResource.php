<?php

declare(strict_types=1);

namespace App\Admin\Resource\Rbac;

use Core\Model\Role;
use Core\Resource\AbstractResource;

/**
 * 角色管理 - 详情 - 资源.
 *
 * @property Role $resource
 */
class RoleResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id, // 角色 ID
            'name' => $this->resource->name, // 名称
            'remark' => $this->resource->remark ?? '', // 备注
            'type' => $this->resource->type, // 类型
            'typeText' => $this->resource->typeText, // 类型 - 文字
            'status' => $this->resource->status, // 状态
            'statusText' => $this->resource->statusText, // 状态 - 文字
            'sort' => $this->resource->sort, // 排序
            'createdAt' => $this->toDateTimeString($this->resource->createdAt), // 创建时间
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt), // 修改时间
        ];
    }
}
