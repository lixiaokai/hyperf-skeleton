<?php

declare(strict_types=1);

namespace App\Admin\Controller\Rbac;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Rbac\PermissionRequest;
use App\Admin\Resource\Rbac\PermissionResource;
use Core\Controller\AbstractController;
use Core\Service\Rbac\PermissionService;
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
 * 权限管理 - 控制器.
 */
#[Controller('admin/rbac/permission')]
#[Middlewares([AuthMiddleware::class])]
class PermissionController extends AbstractController
{
    #[Inject]
    protected PermissionService $service;

    /**
     * 权限管理 - 列表.
     */
    #[GetMapping('')]
    public function index(): ResponseInterface
    {
        $permissionTrees = $this->service->trees();

        return Response::withData($permissionTrees, ''); // 列表不输出提示
    }

    /**
     * 权限管理 - 详情.
     */
    #[GetMapping('{id}')]
    public function show(int $id): ResponseInterface
    {
        $permission = $this->service->getById($id);

        return PermissionResource::make($permission);
    }

    /**
     * 权限管理 - 创建.
     */
    public function create(PermissionRequest $request): ResponseInterface
    {
        $permission = $this->service->create($request->validated());

        return Response::withData(PermissionResource::make($permission));
    }

    /**
     * 权限管理 - 收集.
     */
    #[PostMapping('')]
    public function collect(): ResponseInterface
    {
        $this->service->collect();

        return Response::success();
    }

    /**
     * 权限管理 - 修改.
     */
    #[PutMapping('{id}')]
    public function update(PermissionRequest $request, int $id): ResponseInterface
    {
        $permission = $this->service->getById($id);
        $permission = $this->service->update($permission, $request->validated(PermissionRequest::SCENE_UPDATE));

        return Response::withData(PermissionResource::make($permission));
    }

    /**
     * 权限管理 - 删除.
     */
    #[DeleteMapping('{id}')]
    public function delete(int $id): ResponseInterface
    {
        $permission = $this->service->getById($id);
        $this->service->delete($permission);

        return Response::success();
    }
}
