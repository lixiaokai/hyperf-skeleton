<?php

declare(strict_types=1);

namespace App\Admin\Controller\Rbac;

use App\Admin\Collection\Rbac\RoleCollection;
use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Rbac\RolePermissionRequest;
use App\Admin\Request\Rbac\RoleRequest;
use App\Admin\Resource\Rbac\RoleResource;
use Core\Constants\ContextKey;
use Core\Controller\AbstractController;
use Core\Service\Rbac\RoleService;
use Core\Service\Rbac\TenantService;
use Hyperf\Context\Context;
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
 * 角色管理 - 控制器.
 */
#[Controller('admin/rbac/role')]
#[Middlewares([AuthMiddleware::class])]
class RoleController extends AbstractController
{
    #[Inject]
    protected RoleService $service;

    #[Inject]
    protected TenantService $tenantService;

    /**
     * 角色管理 - 列表.
     */
    #[GetMapping('')]
    public function index(): ResponseInterface
    {
        $tenantId = Context::get(ContextKey::TENANT_ID);
        $roles = $this->service->list($tenantId);

        return RoleCollection::make($roles);
    }

    /**
     * 角色管理 - 详情.
     */
    #[GetMapping('{id}')]
    public function show(int $id): ResponseInterface
    {
        $role = $this->service->getById($id);

        return RoleResource::make($role);
    }

    /**
     * 角色管理 - 创建.
     */
    #[PostMapping('')]
    public function create(RoleRequest $request): ResponseInterface
    {
        $tenantId = Context::get(ContextKey::TENANT_ID);
        $tenant = $this->tenantService->getById($tenantId);
        $role = $this->service->create($request->validated(), $tenant);

        return Response::withData(RoleResource::make($role));
    }

    /**
     * 角色管理 - 修改.
     */
    #[PutMapping('{id}')]
    public function update(int $id, RoleRequest $request): ResponseInterface
    {
        $role = $this->service->getById($id);
        $role = $this->service->update($role, $request->validated(RoleRequest::SCENE_UPDATE));

        return Response::withData(RoleResource::make($role));
    }

    /**
     * 角色管理 - 启用.
     */
    #[PutMapping('{id}/enable')]
    public function enable(int $id): ResponseInterface
    {
        $role = $this->service->getById($id);
        $this->service->enable($role);

        return Response::success();
    }

    /**
     * 角色管理 - 禁用.
     */
    #[PutMapping('{id}/disable')]
    public function disable(int $id): ResponseInterface
    {
        $role = $this->service->getById($id);
        $this->service->disable($role);

        return Response::success();
    }

    /**
     * 角色管理 - 删除.
     */
    #[DeleteMapping('{id}')]
    public function delete(int $id): ResponseInterface
    {
        $role = $this->service->getById($id);
        $this->service->delete($role);

        return Response::success();
    }

    /**
     * 角色管理 - 设置权限.
     */
    #[PutMapping('{id}/bind-permission')]
    public function bindPermission(int $id, RolePermissionRequest $request): ResponseInterface
    {
        $role = $this->service->getById($id);
        ['permissionIds' => $permissionIds] = $request->validated();
        $this->service->bindPermissions($role, $permissionIds);

        return Response::success();
    }
}
