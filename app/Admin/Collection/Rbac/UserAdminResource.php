<?php

declare(strict_types=1);

namespace App\Admin\Collection\Rbac;

use Core\Model\UserAdmin;

/**
 * 总后台用户 - 列表 - 资源.
 *
 * @property UserAdmin $resource
 */
class UserAdminResource extends \App\Admin\Resource\Rbac\UserAdminResource
{
    // 由于 [ 列表 ] 和 [ 详情 ] API 一样，这里直接读取 [ 详情 ] 资源
}
