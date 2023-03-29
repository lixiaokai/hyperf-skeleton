<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Resource\Common\RefreshTokenResource;
use Core\Controller\AbstractController;
use Core\Service\User\UserAuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户 - 刷新令牌 - 控制器.
 */
#[Controller('admin/common/user-admin')]
#[Middlewares([AuthMiddleware::class])]
class UserAdminController extends AbstractController
{
    #[Inject]
    protected UserAuthService $userAuthService;

    /**
     * 刷新令牌.
     */
    #[PostMapping('refresh-token')]
    public function refreshToken(): ResponseInterface
    {
        $user = $this->userAuthService->refreshToken();

        return RefreshTokenResource::make($user);
    }
}
