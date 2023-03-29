<?php

namespace Core\Model\Traits;

trait UserActionTrail
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
     * 检查 - 密码是否相同.
     */
    public function checkPassword(string $password): bool
    {
        if (($userAuth = $this->password) === null) {
            return false;
        }

        return $userAuth->checkPassword($password);
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
        return $this->tenants->contains('id', $tenantId);
    }
}
