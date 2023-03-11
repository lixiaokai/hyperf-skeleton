<?php

namespace Core\Service\Rbac;

use Core\Exception\BusinessException;
use Core\Exception\NotFoundException;
use Core\Model\Menu;
use Core\Repository\MenuRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;

/**
 * 菜单 - 服务类.
 */
class MenuService extends AbstractService
{
    #[Inject]
    protected MenuRepository $repo;

    public function search(array $searchParams = [], string $platform = null): PaginatorInterface
    {
        $query = $this->repo->getQuery()
            ->when($platform, fn (Builder $query) => $query->where(Menu::column('platform'), $platform))
            ->orderByDesc('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 菜单 - 详情.
     */
    public function get(int $id): Menu
    {
        try {
            $menu = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new NotFoundException('菜单信息不存在');
        }

        return $menu;
    }

    /**
     * 菜单 - 创建.
     */
    public function create(array $data): Menu
    {
        return $this->repo->create($data);
    }

    /**
     * 菜单 - 修改.
     */
    public function update(Menu $menu, array $data): Menu
    {
        if (! $menu->canUpdate()) {
            throw new BusinessException('不允许修改');
        }

        return $this->repo->update($menu, $data);
    }

    /**
     * 菜单 - 删除.
     */
    public function delete(Menu $menu): bool
    {
        if (! $menu->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($menu);
    }

    /**
     * 菜单 - 启用.
     */
    public function enable(Menu $menu): Menu
    {
        return $this->repo->enable($menu);
    }

    /**
     * 菜单 - 禁用.
     */
    public function disable(Menu $menu): Menu
    {
        return $this->repo->disable($menu);
    }
}
