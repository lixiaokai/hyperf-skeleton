<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Platform;
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
 * @method Menu              create(array $data)
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
     * @param  null|string       $platform 终端平台
     * @param  null|string       $status   状态
     * @return Collection|Menu[]
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
            ->when($platform, fn (Builder $query) => $query->where(Menu::column('platform'), $platform))
            ->when($status, fn (Builder $query) => $query->where(Menu::column('status'), $status))
            ->orderByDesc(Menu::column('sort'))
            ->orderBy(Menu::column('id'))
            ->get();
    }

    /**
     * 菜单 - 树.
     *
     * @see MenuRepositoryTest::testGetTrees()
     *
     * @param null|string $platform 终端平台
     * @param null|string $status   状态
     */
    public function getTrees(string $platform = null, string $status = null): array
    {
        return TreeHelper::toTrees(
            $this->getList($platform, $status)->toArray()
        );
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
