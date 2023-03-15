<?php

declare(strict_types=1);

namespace App\Admin\Collection\Rbac;

use Core\Resource\AbstractCollection;

/**
 * 总后台用户 - 列表 - 集合.
 */
class UserAdminCollection extends AbstractCollection
{
    public ?string $collects = UserAdminResource::class;
}
