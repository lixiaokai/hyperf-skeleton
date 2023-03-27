<?php

namespace Core\Model\Traits;

trait TenantActionTrail
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
     * 能否 - 启用.
     */
    public function canEnable(): bool
    {
        return $this->isLock() === false;
    }

    /**
     * 能否 - 禁用.
     */
    public function canDisable(): bool
    {
        return $this->isLock() === false;
    }

    /**
     * 是否 - 锁定.
     */
    public function isLock(): bool
    {
        return $this->id === config('tenant.admin.id');
    }
}
