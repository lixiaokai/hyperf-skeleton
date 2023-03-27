<?php

declare(strict_types=1);

namespace App\Admin\Resource\Rbac;

use Core\Model\Permission;
use Core\Resource\AbstractResource;

/**
 * 权限 - 资源.
 *
 * @property Permission $resource
 */
class PermissionResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'parentId' => $this->resource->parentId,
            'appId' => $this->resource->appId,
            'route' => $this->resource->route,
            'attachRoutes' => $this->resource->attachRoutes,
            'name' => $this->resource->name,
            'desc' => $this->resource->desc,
            'sort' => $this->resource->sort,
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
            'deletedAt' => $this->toDateTimeString($this->resource->deletedAt),
        ];
    }
}
