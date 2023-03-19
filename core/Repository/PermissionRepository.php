<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Platform;
use Core\Exception\BusinessException;
use Core\Model\Permission;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Kernel\Helper\TreeHelper;

/**
 * 权限 - 仓库类.
 *
 * @method Permission              getById(int $id)
 * @method Collection|Permission[] getByIds(array $ids, array $columns = ['*'])
 * @method Permission              create(array $data)
 * @method Permission              update(Permission $model, array $data)
 */
class PermissionRepository extends AbstractRepository
{
    protected Model|string $modelClass = Permission::class;

    /**
     * 权限 - 列表.
     *
     * @param  null|string             $platform 终端平台
     * @return Collection|Permission[]
     */
    public function getList(string $platform = null): array|Collection
    {
        if ($platform && ! Platform::has($platform)) {
            throw new BusinessException('传入的 [ 终端平台 ] 参数不合法');
        }

        return $this->getQuery()
            ->when($platform, fn (Builder $query) => $query->where(Permission::column('platform'), $platform))
            ->orderByDesc(Permission::column('sort'))
            ->orderBy(Permission::column('id'))
            ->get();
    }

    /**
     * 权限 - 树.
     *
     * @param null|string $platform 终端平台
     */
    public function getTrees(string $platform = null): array
    {
        return TreeHelper::toTrees(
            $this->getList($platform)->toArray()
        );
    }
}
