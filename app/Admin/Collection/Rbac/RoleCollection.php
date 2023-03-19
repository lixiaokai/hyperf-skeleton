<?php

declare(strict_types=1);

namespace App\Admin\Collection\Rbac;

use Core\Resource\AbstractCollection;

/**
 * 角色管理 - 列表 - 集合.
 */
class RoleCollection extends AbstractCollection
{
    public ?string $collects = RoleResource::class;

    public function toArray(): array
    {
        return $this->collection->toArray();
    }
}
