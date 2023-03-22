<?php

declare(strict_types=1);

namespace App\Admin\Controller\Public;

use App\Admin\Request\Public\AccountLoginRequest;
use App\Admin\Request\Public\SmsLoginRequest;
use App\Admin\Request\Public\SmsLoginSendRequest;
use App\Admin\Resource\Public\LoginResource;
use Core\Annotation\LoginLimit;
use Core\Constants\Platform;
use Core\Controller\AbstractController;
use Core\Service\User\UserAdminAuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 账号登录 - 控制器.
 *
 * 需要登录但不需要权限验证的接口
 */
#[Controller('admin/public/auth')]
class AuthController extends AbstractController
{
    #[Inject]
    protected UserAdminAuthService $userAdminAuthService;

    /**
     * 账号 - 登录.
     *
     * 方式：手机号 + 密码
     */
    #[PostMapping('account-login'), LoginLimit(id: 'phone', prefix: Platform::ADMIN . ':account')]
    public function accountLogin(AccountLoginRequest $request): ResponseInterface
    {
        ['phone' => $phone, 'password' => $password] = $request->validated();
        $userAdmin = $this->userAdminAuthService->accountLogin($phone, $password);

        return LoginResource::make($userAdmin);
    }

    /**
     * 验证码 - 登录.
     *
     * 方式：手机号 + 验证码
     */
    #[PostMapping('sms-login'), LoginLimit(id: 'phone', prefix: Platform::ADMIN . ':sms')]
    public function smsLogin(SmsLoginRequest $request): ResponseInterface
    {
        ['phone' => $phone, 'code' => $code] = $request->validated();
        $userAdmin = $this->userAdminAuthService->smsLogin($phone, $code);

        return LoginResource::make($userAdmin);
    }

    /**
     * 验证码 - 发送.
     */
    #[PostMapping('sms-send')]
    public function smsSend(SmsLoginSendRequest $request): ResponseInterface
    {
        ['phone' => $phone] = $request->validated();
        $codeResult = $this->userAdminAuthService->smsSend($phone);

        return Response::withData([
            'phone' => $phone,
            'code' => config('app_env') === 'dev' ? $codeResult->code : '', // 开发环境将输出验证码，方便使用
            'timeout' => $codeResult->expire,
            'timeoutString' => $codeResult->getExpiredString(),
        ]);
    }
}