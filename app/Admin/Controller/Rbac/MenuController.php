<?php

declare(strict_types=1);

namespace App\Admin\Controller\Rbac;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Rbac\MenuRequest;
use App\Admin\Resource\Rbac\MenuResource;
use Core\Controller\AbstractController;
use Core\Service\Rbac\MenuService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 菜单管理 - 控制器.
 */
#[Controller('admin/rbac/menu')]
#[Middlewares([AuthMiddleware::class])]
class MenuController extends AbstractController
{
    #[Inject]
    protected MenuService $service;

    /**
     * 菜单管理 - 列表.
     */
    #[GetMapping('')]
    public function index(): ResponseInterface
    {
        $menuTrees = $this->service->trees();

        return Response::withData($menuTrees);
    }

    /**
     * 菜单管理 - 详情.
     */
    #[GetMapping('{id}')]
    public function show(int $id): ResponseInterface
    {
        $menu = $this->service->getById($id);

        return MenuResource::make($menu);
    }

    /**
     * 菜单管理 - 创建.
     */
    #[PostMapping('')]
    public function create(MenuRequest $request): ResponseInterface
    {
        $menu = $this->service->create($request->validated());

        return Response::withData(MenuResource::make($menu));
    }

    /**
     * 菜单管理 - 修改.
     */
    #[PutMapping('{id}')]
    public function update(MenuRequest $request, int $id): ResponseInterface
    {
        $menu = $this->service->getById($id);
        $menu = $this->service->update($menu, $request->validated(MenuRequest::SCENE_UPDATE));

        return Response::withData(MenuResource::make($menu));
    }

    /**
     * 菜单管理 - 删除.
     */
    #[DeleteMapping('{id}')]
    public function delete(int $id): ResponseInterface
    {
        $menu = $this->service->getById($id);
        $this->service->delete($menu);

        return Response::success();
    }

    /**
     * 菜单管理 - 启用.
     */
    #[PutMapping('{id}/enable')]
    public function enable(int $id): ResponseInterface
    {
        $menu = $this->service->getById($id);
        $this->service->enable($menu);

        return Response::success();
    }

    /**
     * 菜单管理 - 禁用.
     */
    #[PutMapping('{id}/disable')]
    public function disable(int $id): ResponseInterface
    {
        $menu = $this->service->getById($id);
        $this->service->disable($menu);

        return Response::success();
    }
}
