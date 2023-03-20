<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Common\ProfileResetPasswordRequest;
use App\Admin\Resource\Common\MyProFileResource;
use Core\Constants\ContextKey;
use Core\Controller\AbstractController;
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
        $userAdmin = $this->userAdminService->getByUserId($uid);

        return MyProFileResource::make($userAdmin);
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
}
