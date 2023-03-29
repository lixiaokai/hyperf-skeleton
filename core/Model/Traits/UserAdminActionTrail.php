<?php

declare(strict_types=1);

namespace Core\Model\Traits;

use Core\Model\Role;
use Hyperf\Context\Context;

trait UserAdminActionTrail
{
    /**
     * 能否 - 修改.
     */
    public function canUpdate(): bool
    {
        return true;
    }

    /**
     * 能否 - 删除.
     */
    public function canDelete(): bool
    {
        return false;
    }

    /**
     * 是否 - 有权限.
     *
     * @see UserAdminActionTrailTest::testCan()
     */
    public function can(string $route): bool
    {
        $id = 'Permission:' . $route;
        return Context::getOrSet($id, function () use ($route) {
            if ($this->isAdministrator()) {
                return true;
            }
            return $this->getPermissions()->contains('route', $route);
        });
    }

    /**
     * 是否拥有 - 某应用.
     */
    public function hasApp(string $appId): bool
    {
        return $this->apps->contains('id', $appId);
    }

    /**
     * 是否拥有 - 某租户.
     */
    public function hasTenant(int $tenantId): bool
    {
        // return $this->tenants()->where(Tenant::column('id'), $tenantId)->exists();
        return $this->tenants->contains('id', $tenantId);
    }

    /**
     * 是否 - 超级管理员.
     *
     * 说明：检查拥有的角色中是否包含超管角色
     * 注意：超管角色状态永远都是开启的，这里不用加状态查询条件
     *
     * @see UserAdminActionTrailTest::testIsAdministrator()
     */
    public function isAdministrator(): bool
    {
        return $this->roles->contains(fn (Role $role) => $role->isAdministrator());
    }
}
