<?php

declare(strict_types=1);

namespace App\Demo\Resource;

use Core\Model\Test;
use Core\Resource\AbstractResource;

/**
 * 测试 - 列表 - 资源.
 *
 * @property Test $resource
 */
class TestResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'password' => $this->resource->password,
            'status' => $this->resource->status,
            'statusText' => $this->resource->statusText,
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
            'deletedAt' => $this->toDateTimeString($this->resource->deletedAt),
        ];
    }
}
