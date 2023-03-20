<?php

declare(strict_types=1);

namespace App\Admin\Resource\Common;

use Core\Model\Role;
use Core\Model\UserAdmin;
use Core\Resource\AbstractResource;

/**
 * 我的 - 详情 - 资源.
 *
 * @property UserAdmin $resource
 */
class MyProFileResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->userId,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'status' => $this->resource->status,
            'statusText' => $this->resource->statusText,
            'roles' => $this->resource->roles()->orderByDesc('sort')->get()->map(function (Role $role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'status' => $role->status,
                    'statusText' => $role->statusText,
                ];
            }),
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
        ];
    }
}
