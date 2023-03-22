<?php

namespace Core\Service\User;

use Core\Constants\CaptchaType;
use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Model\UserAdmin;
use Core\Service\Captcha\CaptchaService;
use Core\Service\Captcha\CodeResult;
use Core\Service\Sms\SmsService;
use Core\Service\Sms\Template\CaptchaMessage;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;

/**
 * 总后台用户 - 认证 - 服务类.
 */
class UserAdminAuthService extends UserAdminService
{
    #[Inject]
    protected CaptchaService $captchaService;

    #[Inject]
    protected SmsService $smsService;

    /**
     * 用户 - 账号登录.
     *
     * 方式：手机号 + 密码
     */
    public function accountLogin(string $phone, string $password): UserAdmin
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
     * 用户 - 验证码登录.
     *
     * 方式：手机号 + 验证码
     */
    public function smsLogin(string $phone, string $code): UserAdmin
    {
        $userAdmin = $this->getByPhone($phone);
        if ($userAdmin->isDisable()) {
            throw new BusinessException('当前账号已禁用');
        }
        if ($userAdmin->user->isDisable()) {
            throw new BusinessException('基础账号已禁用');
        }
        if (! $this->captchaService->hasCode($phone, $code, CaptchaType::LOGIN)) {
            throw new BusinessException('验证码 不正确');
        }

        return $userAdmin;
    }

    /**
     * 用户 - 验证码登录 - 短信发送.
     */
    public function smsSend(string $phone): CodeResult
    {
        $codeResult = $this->captchaService->genCode($phone, CaptchaType::LOGIN); // 获取验证码
        $this->smsService->send($phone, new CaptchaMessage($codeResult->code)); // 发送验证码

        return $codeResult;
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
