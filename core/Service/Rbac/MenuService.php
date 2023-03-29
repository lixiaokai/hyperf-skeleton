<?php

declare(strict_types=1);

namespace Core\Service\Rbac;

use Core\Constants\AppId;
use Core\Exception\BusinessException;
use Core\Model\Menu;
use Core\Repository\MenuRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\NotFoundException;

/**
 * 菜单 - 服务类.
 */
class MenuService extends AbstractService
{
    #[Inject]
    protected MenuRepository $repo;

    /**
     * 菜单 - 列表 ( 查询分页 ).
     *
     * @param array $searchParams 查询参数
     */
    public function search(array $searchParams = [], string $appId = AppId::ADMIN): PaginatorInterface
    {
        $query = $this->repo->getQuery()
            ->when($appId, fn (Builder $query) => $query->where(Menu::column('app_id'), $appId))
            ->orderByDesc('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 菜单 - 列表 ( 树 ).
     */
    public function trees(string $appId = AppId::ADMIN, string $status = null): array
    {
        return $this->repo->getTrees($appId, $status);
    }

    /**
     * 菜单 - 详情.
     */
    public function getById(int $id): Menu
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
    public function create(array $data, string $appId = AppId::ADMIN): Menu
    {
        if (! AppId::has($appId)) {
            throw new BusinessException("应用 ID '{$appId}' 是不允许的");
        }

        return $this->repo->create($data, $appId);
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
