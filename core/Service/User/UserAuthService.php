<?php

namespace Core\Service\User;

use Core\Constants\AccountType;
use Core\Constants\CaptchaType;
use Core\Constants\ContextKey;
use Core\Contract\UserInterface;
use Core\Exception\BusinessException;
use Core\Service\AbstractService;
use Core\Service\Captcha\CaptchaService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户 - 认证 - 服务类.
 */
class UserAuthService extends AbstractService
{
    #[Inject]
    protected UserService $userService;

    /**
     * 用户 - 账号登录.
     *
     * 方式：手机号|账号|邮箱 + 密码
     *
     * @param string $accountType 账号类型 ( @see AccountType::class )
     */
    public function passwordLogin(string $account, string $password, string $accountType, int $tenantId, string $appId): UserInterface
    {
        $user = match ($accountType) {
            AccountType::EMAIL => $this->userService->getByEmail($account),
            AccountType::PHONE => $this->userService->getByPhone($account),
            default => $this->userService->getByUsername($account),
        };

        if ($user->isDisable()) {
            throw new BusinessException('基础账号已禁用');
        }
        if (! $user->checkPassword($password)) {
            throw new BusinessException('手机号或密码错误');
        }
        if (! $user->hasApp($appId)) {
            throw new BusinessException('账号不属于该应用');
        }
        if (! $user->hasTenant($tenantId)) {
            throw new BusinessException('账号不属于该租户');
        }

        return $user;
    }

    /**
     * 用户 - 验证码登录.
     *
     * 方式：手机号 + 验证码
     */
    public function smsLogin(string $phone, string $code, int $tenantId, string $appId): UserInterface
    {
        if (! make(CaptchaService::class)->hasCode($phone, $code, CaptchaType::LOGIN)) {
            throw new BusinessException('验证码 不正确');
        }
        $user = $this->userService->getByPhone($phone);
        if ($user->isDisable()) {
            throw new BusinessException('基础账号已禁用');
        }
        if (! $user->hasApp($appId)) {
            throw new BusinessException('账号不属于该应用');
        }
        if (! $user->hasTenant($tenantId)) {
            throw new BusinessException('账号不属于该租户');
        }

        return $user;
    }

    /**
     * 用户 - 刷新 Token.
     */
    public function refreshToken(): UserInterface
    {
        // Todo: 旧 $token 处理  ( 放入带有过期时间的黑名单队列中 )
        // Todo: $refreshToken 处理

        $user = Context::get(ContextKey::USER);
        if ($user === null) {
            throw new BusinessException('用户未登录');
        }

        return $user;
    }
}
