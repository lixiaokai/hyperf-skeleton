<?php

declare(strict_types=1);

namespace Core\Model\Traits;

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
     */
    public function can(string $route): bool
    {
        static $permission;
        if (empty($routers)) {
            $permission = $this->getPermissions();
        }

        return $permission->contains('route', $route);
    }

    /**
     * 检查 - 密码是否相同.
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, (string) $this->password);
    }
}
