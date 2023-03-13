<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use Core\Constants\Platform;
use Core\Constants\Status;
use Core\Controller\AbstractController;
use Core\Service\Rbac\MenuService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 公共 - 控制器.
 *
 * 需要登录但不需要权限验证的接口
 */
#[Controller('admin/common')]
class CommonController extends AbstractController
{
    #[Inject]
    protected MenuService $service;

    /**
     * 菜单 - 列表 ( 树 ).
     */
    #[GetMapping('menu')]
    public function menu(): ResponseInterface
    {
        $menuTrees = $this->service->trees(Platform::ADMIN, Status::ENABLE);

        return Response::withData($menuTrees);
    }
}
