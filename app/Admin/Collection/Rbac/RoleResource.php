<?php

declare(strict_types=1);

namespace App\Admin\Collection\Rbac;

use Core\Model\Role;

/**
 * 角色管理 - 列表 - 资源.
 *
 * @property Role $resource
 */
class RoleResource extends \App\Admin\Resource\Rbac\RoleResource
{
    // 由于 [ 列表 ] 和 [ 详情 ] API 一样，这里直接读取 [ 详情 ] 资源
}
