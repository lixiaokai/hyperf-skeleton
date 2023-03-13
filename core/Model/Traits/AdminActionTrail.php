<?php

declare(strict_types=1);

namespace Core\Model\Traits;

use Core\Constants\Status;

trait AdminActionTrail
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
     * 是否 - 启用.
     */
    public function isEnable(): bool
    {
        return $this->user->status === Status::ENABLE;
    }

    /**
     * 是否 - 禁用.
     */
    public function isDisable(): bool
    {
        return $this->user->status === Status::DISABLE;
    }
}
