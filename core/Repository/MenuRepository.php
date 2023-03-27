<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\AppId;
use Core\Constants\Status;
use Core\Exception\BusinessException;
use Core\Model\Menu;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Kernel\Helper\TreeHelper;

/**
 * 菜单 - 仓库类.
 *
 * @method Menu              getById(int $id)
 * @method Collection|Menu[] getByIds(array $ids, array $columns = ['*'])
 * @method Menu              update(Menu $model, array $data)
 */
class MenuRepository extends AbstractRepository
{
    protected Model|string $modelClass = Menu::class;

    /**
     * 菜单 - 列表.
     *
     * @see MenuRepositoryTest::testGetList()
     *
     * @return Collection|Menu[]
     */
    public function getList(string $appId = null, string $status = null): array|Collection
    {
        if ($appId && ! AppId::has($appId)) {
            throw new BusinessException('传入的 [ 终端平台 ] 参数不合法');
        }
        if ($status && ! Status::has($status)) {
            throw new BusinessException('传入的 [ 状态 ] 参数不合法');
        }

        return $this->getQuery()
            ->when($appId, fn (Builder $query) => $query->where(Menu::column('app_id'), $appId))
            ->when($status, fn (Builder $query) => $query->where(Menu::column('status'), $status))
            ->orderByDesc(Menu::column('sort'))
            ->orderBy(Menu::column('id'))
            ->get();
    }

    /**
     * 菜单 - 树.
     *
     * @see MenuRepositoryTest::testGetTrees()
     */
    public function getTrees(string $appId = null, string $status = null): array
    {
        return TreeHelper::toTrees(
            $this->getList($appId, $status)->toArray()
        );
    }

    /**
     * 菜单 - 创建.
     */
    public function create(array $data, string $appId = null): Model|Menu
    {
        if ($appId) {
            $data = array_merge($data, compact('appId'));
        }

        return parent::create($data);
    }

    /**
     * 菜单 - 启用.
     */
    public function enable(Menu $menu): Menu
    {
        $menu->status = Status::ENABLE;
        $menu->save();

        return $menu;
    }

    /**
     * 菜单 - 禁用.
     */
    public function disable(Menu $menu): Menu
    {
        $menu->status = Status::DISABLE;
        $menu->save();

        return $menu;
    }
}
