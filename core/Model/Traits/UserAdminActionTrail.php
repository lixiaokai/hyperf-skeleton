<?php

declare(strict_types=1);

namespace Core\Model\Traits;

use Core\Constants\Status;
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
     * 检查 - 密码是否相同.
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, (string) $this->password);
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
     * 检查拥有的角色中是否包含超管角色
     *
     * @see UserAdminActionTrailTest::testIsAdministrator()
     */
    public function isAdministrator(): bool
    {
        return $this->roles()
            ->where(Role::column('status'), Status::ENABLE)
            ->get()
            ->contains(fn (Role $role) => $role->isAdministrator());
    }
}
