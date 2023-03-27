<?php

declare(strict_types=1);

namespace App\Admin\Resource\Rbac;

use Core\Model\Menu;
use Core\Resource\AbstractResource;

/**
 * 菜单 - 资源.
 *
 * @property Menu $resource
 */
class MenuResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'parentId' => $this->resource->parentId,
            'appId' => $this->resource->appId,
            'path' => $this->resource->path,
            'route' => $this->resource->route,
            'name' => $this->resource->name,
            'desc' => $this->resource->desc,
            'icon' => $this->resource->icon,
            'status' => $this->resource->status,
            'statusText' => $this->resource->statusText,
            'sort' => $this->resource->sort,
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
        ];
    }
}
