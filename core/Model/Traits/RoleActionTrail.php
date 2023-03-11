<?php

namespace Core\Model\Traits;

trait RoleActionTrail
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
     * 是否 - 超级管理员角色.
     */
    public function isAdministrator(): bool
    {
        return $this->id === self::ADMINISTRATOR_ROLE_ID;
    }
}
