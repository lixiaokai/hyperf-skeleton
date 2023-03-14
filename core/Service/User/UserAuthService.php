<?php

namespace Core\Service\User;

use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Model\User;
use Hyperf\Context\Context;

/**
 * 用户认证 - 服务类.
 */
class UserAuthService extends UserService
{
    /**
     * 用户 - 登录.
     */
    public function login(string $phone, string $password): User
    {
        $user = $this->getByPhone($phone);
        if ($user->isDisable()) {
            throw new BusinessException('账号已禁用');
        }
        if (! $user->checkPassword($password)) {
            throw new BusinessException('手机号或密码错误');
        }

        return $user;
    }

    /**
     * 用户 - 刷新 Token.
     *
     * @see User::$jwt 直接通过用户模型重新取 token
     */
    public function refreshToken(): User
    {
        // Todo: 旧 $token 处理  ( 放入带有过期时间的黑名单队列中 )
        // Todo: $refreshToken 处理

        return Context::get(ContextKey::USER);
    }
}
