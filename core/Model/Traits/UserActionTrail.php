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
        return password_verify($password, $this->password);
    }
}
