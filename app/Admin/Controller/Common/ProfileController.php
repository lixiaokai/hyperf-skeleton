<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Common\ChangePhoneRequest;
use App\Admin\Request\Common\ChangePhoneSendRequest;
use App\Admin\Request\Common\ProfileResetPasswordRequest;
use App\Admin\Resource\Common\ProfileResource;
use Core\Constants\CaptchaType;
use Core\Constants\ContextKey;
use Core\Controller\AbstractController;
use Core\Service\Sms\SmsFactory;
use Core\Service\User\UserAdminService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PutMapping;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 个人中心 - 控制器.
 */
#[Controller('admin/common/profile')]
#[Middlewares([AuthMiddleware::class])]
class ProfileController extends AbstractController
{
    #[Inject]
    protected UserAdminService $userAdminService;

    /**
     * 我的 - 详情.
     */
    #[GetMapping('')]
    public function show(): ResponseInterface
    {
        $uid = Context::get(ContextKey::UID);
        $userAdmin = $this->userAdminService->getById($uid);

        return ProfileResource::make($userAdmin);
    }

    /**
     * 我的 - 修改密码.
     */
    #[PutMapping('reset-password')]
    public function resetPassword(ProfileResetPasswordRequest $request): ResponseInterface
    {
        $userAdmin = Context::get(ContextKey::USER_ADMIN);
        ['password' => $password] = $request->validated();
        $this->userAdminService->resetPassword($userAdmin, $password);

        return Response::success();
    }

    /**
     * 我的 - 更换手机号.
     */
    #[PutMapping('change-phone')]
    public function changePhone(ChangePhoneRequest $request): ResponseInterface
    {
        ['phone' => $phone, 'code' => $code] = $request->validated();
        $userAdmin = Context::get(ContextKey::USER_ADMIN);
        $this->userAdminService->changePhone($userAdmin, $phone, $code);

        return Response::success();
    }

    /**
     * 我的 - 更换手机号 - 发送验证码.
     */
    #[PutMapping('change-phone-sms-send')]
    public function smsSend(ChangePhoneSendRequest $request): ResponseInterface
    {
        ['phone' => $phone] = $request->validated();
        $codeResult = SmsFactory::send($phone, CaptchaType::CHANGE_PHONE);

        return Response::withData([
            'phone' => $phone,
            'code' => config('app_env') === 'dev' ? $codeResult->code : '', // 开发环境将输出验证码，方便使用
            'timeout' => $codeResult->expire,
            'timeoutString' => $codeResult->getExpiredString(),
        ]);
    }
}
