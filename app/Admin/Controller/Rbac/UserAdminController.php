<?php

declare(strict_types=1);

namespace App\Admin\Controller\Rbac;

use App\Admin\Collection\Rbac\UserAdminCollection;
use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Request\Rbac\UserAdminRequest;
use App\Admin\Resource\Rbac\UserAdminResource;
use Core\Controller\AbstractController;
use Core\Request\SearchRequest;
use Core\Service\User\UserAdminService;
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
 * 总后台用户管理 - 控制器.
 */
#[Controller('admin/rbac/user-admin')]
#[Middlewares([AuthMiddleware::class])]
class UserAdminController extends AbstractController
{
    #[Inject]
    protected UserAdminService $service;

    /**
     * 总后台用户管理 - 列表.
     */
    #[GetMapping('')]
    public function index(SearchRequest $request): ResponseInterface
    {
        $admins = $this->service->search($request->searchParams());

        return UserAdminCollection::make($admins);
    }

    /**
     * 总后台用户管理 - 详情.
     */
    #[GetMapping('{userId}')]
    public function show(int $userId): ResponseInterface
    {
        $admin = $this->service->getByUserId($userId);

        return UserAdminResource::make($admin);
    }

    /**
     * 总后台用户管理 - 创建.
     */
    #[PostMapping('')]
    public function create(UserAdminRequest $request): ResponseInterface
    {
        $userAdmin = $this->service->create($request->validated());

        return Response::withData(UserAdminResource::make($userAdmin));
    }

    /**
     * 总后台用户管理 - 修改.
     */
    #[PutMapping('{userId}')]
    public function update(UserAdminRequest $request, int $userId): ResponseInterface
    {
        $userAdmin = $this->service->getByUserId($userId);
        $userAdmin = $this->service->update($userAdmin, $request->validated(UserAdminRequest::SCENE_UPDATE));

        return Response::withData(UserAdminResource::make($userAdmin));
    }

    /**
     * 总后台用户管理 - 删除.
     */
    #[DeleteMapping('{userId}')]
    public function delete(int $userId): ResponseInterface
    {
        $userAdmin = $this->service->getByUserId($userId);
        $this->service->delete($userAdmin);

        return Response::success();
    }

    /**
     * 总后台用户管理 - 重置密码.
     */
    public function resetPassword(): ResponseInterface
    {
        return Response::success();
    }

    /**
     * 总后台用户管理 - 启用.
     */
    #[PutMapping('{userId}/enable')]
    public function enable(int $userId): ResponseInterface
    {
        $userAdmin = $this->service->getByUserId($userId);
        $this->service->enable($userAdmin);

        return Response::success();
    }

    /**
     * 总后台用户管理 - 禁用.
     */
    #[PutMapping('{userId}/disable')]
    public function disable(int $userId): ResponseInterface
    {
        $userAdmin = $this->service->getByUserId($userId);
        $this->service->disable($userAdmin);

        return Response::success();
    }
}
