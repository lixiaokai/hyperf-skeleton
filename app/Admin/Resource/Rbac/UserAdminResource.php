<?php

declare(strict_types=1);

namespace App\Admin\Resource\Rbac;

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
            'username' => $this->resource->username,
            'nickname' => $this->resource->nickname,
            'phone' => $this->resource->phone,
            'status' => $this->resource->status,
            'statusText' => $this->resource->statusText,
            'roleIds' => $this->resource->roles->pluck('id'),
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
        ];
    }
}
