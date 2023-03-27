<?php

declare(strict_types=1);

namespace Core\Service\Rbac;

use Core\Constants\AppId;
use Core\Model\Role;
use Core\Model\Tenant;
use Core\Repository\RoleRepository;
use Core\Service\AbstractService;
use Hyperf\Database\Model\Collection;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\BusinessException;

/**
 * 角色 - 服务类.
 */
class RoleService extends AbstractService
{
    #[Inject]
    protected RoleRepository $repo;

    /**
     * 角色 - 列表.
     *
     * @return Collection|Role[]
     */
    public function list(int $tenantId = null, string $status = null): array|Collection
    {
        return $this->repo->getList($tenantId, $status);
    }

    /**
     * 角色 - 详情.
     */
    public function getById(int $id): Role
    {
        try {
            $role = $this->repo->getById($id);
        } catch (BusinessException) {
            throw new BusinessException('该角色不存在');
        }

        return $role;
    }

    /**
     * 角色 - 多条详情.
     */
    public function getsByIdsAndTenantId(array $ids, int $tenantId): array|Collection
    {
        return $this->repo->getsByIdsAndTenantId($ids, $tenantId);
    }

    /**
     * 角色 - 创建.
     *
     * 说明：需要同时绑定租户
     */
    #[Transactional]
    public function create(array $data, Tenant $tenant): Role
    {
        // 1. 创建角色基础信息
        $role = $this->repo->create($data);

        // 2. 绑定租户
        $this->bindTenants($role, [$tenant->id]);

        return $role;
    }

    /**
     * 角色 - 修改.
     *
     * 说明：只能修改基础信息
     */
    public function update(Role $role, array $data): Role
    {
        if ($role->isAdministrator()) {
            throw new BusinessException('该角色为超级管理员，不允许操作');
        }

        return $this->repo->update($role, $data);
    }

    /**
     * 角色 - 启用.
     */
    public function enable(Role $role): Role
    {
        if ($role->isAdministrator()) {
            throw new BusinessException('该角色为超级管理员，不允许操作');
        }

        return $this->repo->enable($role);
    }

    /**
     * 角色 - 禁用.
     */
    public function disable(Role $role): Role
    {
        if ($role->isAdministrator()) {
            throw new BusinessException('该角色为超级管理员，不允许操作');
        }

        return $this->repo->disable($role);
    }

    /**
     * 角色 - 删除.
     */
    public function delete(Role $role): bool
    {
        if ($role->isAdministrator()) {
            throw new BusinessException('该角色为超级管理员，不允许操作');
        }
        if (! $role->canDelete()) {
            throw new BusinessException('该角色不允许删除');
        }

        return $this->repo->delete($role);
    }

    /**
     * 角色 - 绑定权限.
     */
    public function bindPermissions(Role $role, array $permissionIds): void
    {
        if ($role->isAdministrator()) {
            throw new BusinessException('该角色为超级管理员，不允许操作');
        }

        $this->repo->bindPermissions($role, $permissionIds);
    }

    /**
     * 角色 - 绑定租户.
     */
    public function bindTenants(Role $role, array $tenantIds): void
    {
        $this->repo->bindTenants($role, $tenantIds);
    }
}
