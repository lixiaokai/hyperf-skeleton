<?php

declare(strict_types=1);

namespace Core\Service\User;

use Core\Constants\AccountType;
use Core\Exception\BusinessException;
use Core\Model\User;
use Core\Model\UserAdmin;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * 总后台用户 - 认证 - 服务类.
 */
class UserAdminAuthService extends UserAuthService
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    /**
     * 账号密码登录.
     *
     * 方式：手机号|账号|邮箱 + 密码
     */
    public function accountLogin(string $account, string $password, int $tenantId, string $appId): UserAdmin
    {
        // 获取登录类型
        $data = ['account' => $account];
        $accountType = match (true) {
            $this->validationFactory->make($data, ['account' => 'email'])->fails() === false => AccountType::EMAIL,
            $this->validationFactory->make($data, ['account' => 'mobile'])->fails() === false => AccountType::PHONE,
            default => AccountType::USERNAME,
        };

        /* @var User $user */
        $user = $this->passwordLogin($account, $password, $accountType, $tenantId, $appId);

        // 总后台账号状态检查
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
