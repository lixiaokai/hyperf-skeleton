<?php

namespace Core\Service\User;

use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Model\UserAdmin;
use Hyperf\Context\Context;

/**
 * 总后台用户 - 认证 - 服务类.
 */
class UserAdminAuthService extends UserAdminService
{
    /**
     * 用户 - 登录.
     */
    public function login(string $phone, string $password): UserAdmin
    {
        $userAdmin = $this->getByPhone($phone);
        if ($userAdmin->isDisable()) {
            throw new BusinessException('当前账号已禁用');
        }
        if ($userAdmin->user->isDisable()) {
            throw new BusinessException('基础账号已禁用');
        }
        if (! $userAdmin->checkPassword($password)) {
            throw new BusinessException('手机号或密码错误');
        }

        return $userAdmin;
    }

    /**
     * 用户 - 刷新 Token.
     */
    public function refreshToken(): UserAdmin
    {
        // Todo: 旧 $token 处理  ( 放入带有过期时间的黑名单队列中 )
        // Todo: $refreshToken 处理

        $userAdmin = Context::get(ContextKey::USER_ADMIN);
        if ($userAdmin === null) {
            throw new BusinessException('用户未登录');
        }

        return $userAdmin;
    }
}
