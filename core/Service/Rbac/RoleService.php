<?php

declare(strict_types=1);

namespace Core\Service\Rbac;

use Core\Model\Role;
use Core\Repository\RoleRepository;
use Core\Service\AbstractService;
use Hyperf\Database\Model\Collection;
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
    public function list(string $platform = null, string $status = null): array|Collection
    {
        return $this->repo->getList($platform, $status);
    }

    /**
     * 角色 - 详情.
     */
    public function getById(int $id): Role
    {
        try {
            $role = $this->repo->getById($id);
        } catch (BusinessException $e) {
            throw new BusinessException('该角色不存在');
        }

        return $role;
    }

    /**
     * 角色 - 创建.
     */
    public function create(array $data): Role
    {
        return $this->repo->create($data);
    }

    /**
     * 角色 - 修改 - 基础信息.
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
        $this->repo->bindPermissions($role, $permissionIds);
    }
}
