<?php

declare(strict_types=1);

namespace App\Admin\Resource;

use Core\Model\UserAdmin;
use Core\Resource\AbstractResource;

/**
 * 总后台用户 - 资源.
 *
 * @property UserAdmin $resource
 */
class UserAdminResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'userId' => $this->resource->userId,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'status' => $this->resource->status,
            'statusText' => $this->resource->statusText,
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
        ];
    }
}
