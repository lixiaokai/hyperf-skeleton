<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use App\Admin\Middleware\AuthMiddleware;
use Core\Controller\AbstractController;
use Core\Service\User\UserAdminMenuService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 公共 - 控制器.
 *
 * 需要登录但不需要权限验证的接口
 */
#[Controller('admin/common/menu')]
#[Middlewares([AuthMiddleware::class])]
class MenuController extends AbstractController
{
    #[Inject]
    protected UserAdminMenuService $service;

    /**
     * 菜单 - 列表 ( 树 ).
     */
    #[GetMapping('')]
    public function listTrees(): ResponseInterface
    {
        $menuTrees = $this->service->getMenuTrees();

        return Response::withData($menuTrees, ''); // 不输出提示
    }
}
