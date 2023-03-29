<?php

namespace Core\Service\User;

use Core\Exception\BusinessException;
use Core\Model\User;
use Core\Model\UserAdmin;

/**
 * 总后台用户 - 认证 - 服务类.
 */
class UserAdminAuthService extends UserAuthService
{
    /**
     * {@inheritDoc}
     */
    public function passwordLogin(string $phone, string $password, int $tenantId, string $appId): UserAdmin
    {
        /* @var User $user */
        $user = parent::passwordLogin($phone, $password, $tenantId, $appId);
        if ($user->userAdmin->isDisable()) {
            throw new BusinessException('总后台账号已禁用');
        }

        return $user->userAdmin;
    }

    /**
     * {@inheritDoc}
     */
    public function smsLogin(string $phone, string $code, int $tenantId, string $appId): UserAdmin
    {
        /* @var User $user */
        $user = parent::smsLogin($phone, $code, $tenantId, $appId);
        if ($user->userAdmin->isDisable()) {
            throw new BusinessException('总后台账号已禁用');
        }

        return $user->userAdmin;
    }
}
