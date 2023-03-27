<?php

namespace Core\Service\User;

use Core\Constants\CaptchaType;
use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Model\UserAdmin;
use Core\Service\AbstractService;
use Core\Service\Captcha\CaptchaService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;

/**
 * 总后台用户 - 认证 - 服务类.
 */
class UserAdminAuthService extends AbstractService
{
    #[Inject]
    protected UserAdminService $userAdminService;

    /**
     * 用户 - 账号登录.
     *
     * 方式：手机号 + 密码
     */
    public function accountLogin(string $phone, string $password, string $appId, int $tenantId): UserAdmin
    {
        $userAdmin = $this->userAdminService->getByPhone($phone);
        if ($userAdmin->isDisable()) {
            throw new BusinessException('登录的总后台账号已禁用');
        }
        if ($userAdmin->user->isDisable()) {
            throw new BusinessException('登录的基础账号已禁用');
        }
        if (! $userAdmin->checkPassword($password)) {
            throw new BusinessException('登录的手机号或密码错误');
        }
        if (! $userAdmin->hasTenant($tenantId)) {
            throw new BusinessException("登录的总后台账号不属于该租户 [{$tenantId}]");
        }

        return $userAdmin;
    }

    /**
     * 用户 - 验证码登录.
     *
     * 方式：手机号 + 验证码
     */
    public function smsLogin(string $phone, string $code): UserAdmin
    {
        $userAdmin = $this->userAdminService->getByPhone($phone);
        if ($userAdmin->isDisable()) {
            throw new BusinessException('当前账号已禁用');
        }
        if ($userAdmin->user->isDisable()) {
            throw new BusinessException('基础账号已禁用');
        }
        if (! make(CaptchaService::class)->hasCode($phone, $code, CaptchaType::LOGIN)) {
            throw new BusinessException('验证码 不正确');
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
