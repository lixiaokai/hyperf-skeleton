<?php

declare(strict_types=1);

namespace App\Admin\Controller\Rbac;

use App\Admin\Collection\Rbac\UserAdminCollection;
use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Rbac\UserAdminRequest;
use App\Admin\Resource\Rbac\UserAdminResource;
use Core\Constants\ContextKey;
use Core\Controller\AbstractController;
use Core\Request\SearchRequest;
use Core\Service\Rbac\TenantService;
use Core\Service\User\UserAdminService;
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
 * 用户管理 - 控制器.
 */
#[Controller('admin/rbac/user-admin')]
#[Middlewares([AuthMiddleware::class])]
class UserAdminController extends AbstractController
{
    #[Inject]
    protected UserAdminService $service;

    #[Inject]
    protected TenantService $tenantService;

    /**
     * 用户管理 - 列表.
     */
    #[GetMapping('')]
    public function index(SearchRequest $request): ResponseInterface
    {
        $userAdmins = $this->service->search($request->searchParams());

        return UserAdminCollection::make($userAdmins);
    }

    /**
     * 用户管理 - 详情.
     */
    #[GetMapping('{id}')]
    public function show(int $id): ResponseInterface
    {
        $userAdmin = $this->service->getById($id);

        return UserAdminResource::make($userAdmin);
    }

    /**
     * 用户管理 - 创建.
     */
    #[PostMapping('')]
    public function create(UserAdminRequest $request): ResponseInterface
    {
        $tenantId = Context::get(ContextKey::TENANT_ID);
        $appId = Context::get(ContextKey::APP_ID);
        $tenant = $this->tenantService->getById($tenantId);
        $userAdmin = $this->service->create($tenant, $request->validated(), $appId);

        return Response::withData(UserAdminResource::make($userAdmin));
    }

    /**
     * 用户管理 - 修改.
     */
    #[PutMapping('{id}')]
    public function update(UserAdminRequest $request, int $id): ResponseInterface
    {
        $tenantId = Context::get(ContextKey::TENANT_ID);
        $appId = Context::get(ContextKey::APP_ID);
        $tenant = $this->tenantService->getById($tenantId);
        $userAdmin = $this->service->getById($id);
        $userAdmin = $this->service->update($tenant, $userAdmin, $request->validated(UserAdminRequest::SCENE_UPDATE), $appId);

        return Response::withData(UserAdminResource::make($userAdmin));
    }

    /**
     * 用户管理 - 删除.
     */
    #[DeleteMapping('{id}')]
    public function delete(int $id): ResponseInterface
    {
        $userAdmin = $this->service->getById($id);
        $this->service->delete($userAdmin);

        return Response::success();
    }

    /**
     * 用户管理 - 重置密码.
     */
    #[PutMapping('{id}/reset-password')]
    public function resetPassword(UserAdminRequest $request, int $id): ResponseInterface
    {
        ['password' => $password] = $request->validated(UserAdminRequest::SCENE_RESET_PASSWORD);
        $userAdmin = $this->service->getById($id);
        $this->service->resetPassword($userAdmin, $password);

        return Response::success();
    }

    /**
     * 用户管理 - 启用.
     */
    #[PutMapping('{id}/enable')]
    public function enable(int $id): ResponseInterface
    {
        $userAdmin = $this->service->getById($id);
        $this->service->enable($userAdmin);

        return Response::success();
    }

    /**
     * 用户管理 - 禁用.
     */
    #[PutMapping('{id}/disable')]
    public function disable(int $id): ResponseInterface
    {
        $userAdmin = $this->service->getById($id);
        $this->service->disable($userAdmin);

        return Response::success();
    }
}
