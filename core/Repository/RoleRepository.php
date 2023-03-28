<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Status;
use Core\Model\Role;
use Core\Model\TenantRole;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

/**
 * 角色 - 仓库类.
 *
 * @method Role              getById(int $id)
 * @method Collection|Role[] getByIds(array $ids, array $columns = ['*'])
 * @method Role              create(array $data)
 * @method Role              update(Role $model, array $data)
 */
class RoleRepository extends AbstractRepository
{
    protected Model|string $modelClass = Role::class;

    /**
     * @return Collection|Role[]
     */
    public function getsByIdsAndTenantId(array $ids, int $tenantId): array|Collection
    {
        return $this->getQuery()
            ->select(Role::column())
            ->leftJoin(TenantRole::table(), TenantRole::column('role_id'), Role::column('id'))
            ->whereIn(Role::column('id'), $ids)
            ->where(TenantRole::column('tenant_id'), $tenantId)
            ->get();
    }

    /**
     * 角色 - 列表.
     *
     * @return Collection|Role[]
     */
    public function getList(int $tenantId = null, string $status = null): array|Collection
    {
        return $this->getQuery()
            ->select(Role::column())
            ->when($tenantId, function (Builder $query) use ($tenantId) {
                $query->leftJoin(TenantRole::table(), TenantRole::column('role_id'), Role::column('id'))
                    ->where(TenantRole::column('tenant_id'), $tenantId);
            })
            ->when($status, fn (Builder $query) => $query->where(Role::column('status'), $status))
            ->orderByDesc(Role::column('sort'))
            ->orderBy(Role::column('id'))
            ->get();
    }

    /**
     * 角色 - 启用.
     */
    public function enable(Role $role): Role
    {
        $role->status = Status::ENABLE;
        $role->save();

        return $role;
    }

    /**
     * 角色 - 禁用.
     */
    public function disable(Role $role): Role
    {
        $role->status = Status::DISABLE;
        $role->save();

        return $role;
    }

    /**
     * 角色 - 绑定权限.
     */
    public function bindPermissions(Role $role, array $permissionIds): array
    {
        return $role->permissions()->sync($permissionIds);
    }

    /**
     * 角色 - 绑定租户.
     */
    public function bindTenants(Role $role, array $tenantIds): array
    {
        return $role->tenants()->sync($tenantIds);
    }
}
