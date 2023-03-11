<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Platform;
use Core\Constants\Status;
use Core\Exception\BusinessException;
use Core\Model\Role;
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
     * 角色 - 列表.
     *
     * @param  null|string       $platform 终端平台
     * @param  null|string       $status   状态
     * @return Collection|Role[]
     */
    public function getList(string $platform = null, string $status = null): array|Collection
    {
        if ($platform && ! Platform::has($platform)) {
            throw new BusinessException('传入的 [ 终端平台 ] 参数不合法');
        }
        if ($status && ! Status::has($status)) {
            throw new BusinessException('传入的 [ 状态 ] 参数不合法');
        }

        return $this->getQuery()
            ->when($platform, fn (Builder $query) => $query->where('platform', $platform))
            ->when($status, fn (Builder $query) => $query->where('status', $status))
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();
    }

    /**
     * 角色 - 修改 - 关联权限菜单.
     */
    public function updateMenus(Role $role, array $menuIds): array
    {
        return $role->menus()->sync($menuIds);
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
}
