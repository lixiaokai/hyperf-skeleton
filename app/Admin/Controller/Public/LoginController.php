<?php

declare(strict_types=1);

namespace App\Admin\Controller\Public;

use App\Admin\Request\Public\LoginRequest;
use App\Admin\Resource\Public\LoginResource;
use Core\Annotation\LoginLimit;
use Core\Constants\Platform;
use Core\Controller\AbstractController;
use Core\Service\User\UserAdminAuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 账号登录 - 控制器.
 *
 * 需要登录但不需要权限验证的接口
 */
#[Controller('admin/public/login')]
class LoginController extends AbstractController
{
    #[Inject]
    protected UserAdminAuthService $userAuthService;

    /**
     * 账号登录.
     */
    #[PostMapping(''), LoginLimit(id: 'phone', prefix: Platform::ADMIN)]
    public function login(LoginRequest $request): ResponseInterface
    {
        ['phone' => $phone, 'password' => $password] = $request->validated();
        $userAdmin = $this->userAuthService->login($phone, $password);

        return LoginResource::make($userAdmin);
    }
}
