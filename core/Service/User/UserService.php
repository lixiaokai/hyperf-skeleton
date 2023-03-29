<?php

declare(strict_types=1);

namespace Core\Service\User;

use Core\Contract\UserInterface;
use Core\Exception\BusinessException;
use Core\Exception\NotFoundException;
use Core\Model\Tenant;
use Core\Model\User;
use Core\Repository\UserRepository;
use Core\Service\AbstractService;
use Core\Service\Rbac\RoleService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户 - 服务类.
 */
class UserService extends AbstractService
{
    #[Inject]
    protected UserRepository $repo;

    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery();

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 用户 - 详情 ( 根据 ID ).
     */
    public function getById(int $id): User
    {
        try {
            $user = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new NotFoundException('基础用户不存在');
        }

        return $user;
    }

    /**
     * 用户 - 详情 ( 根据手机号 ).
     */
    public function getByPhone(string $phone): User
    {
        return $this->repo->getByPhone($phone);
    }

    /**
     * 用户 - 创建.
     */
    public function create(array $data): User
    {
        return $this->repo->create($data);
    }

    /**
     * 用户 - 修改.
     */
    public function update(User $user, array $data): User
    {
        if (! $user->canUpdate()) {
            throw new BusinessException('不允许修改');
        }

        return $this->repo->update($user, $data);
    }

    /**
     * 用户 - 创建|修改.
     *
     * 用户基础信息一般不单独创建,
     * 需要再执行回调函数创建实际对应的扩展用户 ( 例: 总后台用户 )
     *
     * @param  string        $phone    手机号
     * @param  array         $data     用户数据
     * @param  ?callable     $callable 回调函数
     * @return UserInterface 返回回调函数执行后的结果
     */
    public function updateOrCreateByPhone(string $phone, array $data, Tenant $tenant = null, callable $callable = null): UserInterface
    {
        $user = $this->repo->updateOrCreate(['phone' => $phone], $data);

        return $callable !== null ? $callable($user) : $user;
    }

    /**
     * 用户 - 删除.
     */
    public function delete(User $user): bool
    {
        if (! $user->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($user);
    }

    /**
     * 绑定 - 角色.
     */
    public function bindRoles(User $user, array $roleIds, string $appId, Tenant $tenant): void
    {
        $roles = make(RoleService::class)->getsByIdsAndTenantId($roleIds, $tenant->id);
        $this->repo->bindRoles($tenant, $user, $roles, $appId);
    }

    /**
     * 绑定 - 应用.
     */
    public function bindApp(User $user, string $appId): void
    {
        $this->repo->bindApp($user, $appId);
    }

    /**
     * 绑定 - 应用.
     */
    public function bindTenant(User $user, Tenant $tenant): void
    {
        $this->repo->bindTenant($user, $tenant);
    }
}
