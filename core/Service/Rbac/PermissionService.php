<?php

declare(strict_types=1);

namespace Core\Service\Rbac;

use Core\Constants\AppId;
use Core\Exception\BusinessException;
use Core\Model\Permission;
use Core\Repository\PermissionRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\ApplicationInterface;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\NotFoundException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * 权限 - 服务类.
 */
class PermissionService extends AbstractService
{
    #[Inject]
    protected PermissionRepository $repo;

    /**
     * 权限 - 列表 ( 查询分页 ).
     *
     * @param array $searchParams 查询参数
     */
    public function search(array $searchParams = [], string $appId = AppId::ADMIN): PaginatorInterface
    {
        $query = $this->repo->getQuery()
            ->when($appId, fn (Builder $query) => $query->where(Permission::column('app_id'), $appId))
            ->orderByDesc('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 权限 - 列表 ( 树 ).
     */
    public function trees(string $appId = AppId::ADMIN): array
    {
        return $this->repo->getTrees($appId);
    }

    /**
     * 权限 - 详情.
     */
    public function getById(int $id): Permission
    {
        try {
            $permission = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new NotFoundException('权限信息不存在');
        }

        return $permission;
    }

    /**
     * 权限 - 创建.
     */
    public function create(array $data): Permission
    {
        return $this->repo->create($data);
    }

    /**
     * 权限 - 修改.
     */
    public function update(Permission $permission, array $data): Permission
    {
        if (! $permission->canUpdate()) {
            throw new BusinessException('不允许修改');
        }

        return $this->repo->update($permission, $data);
    }

    /**
     * 权限 - 删除.
     */
    public function delete(Permission $permission): bool
    {
        if (! $permission->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($permission);
    }

    /**
     * 权限 - 收集.
     *
     * @see https://hyperf.wiki/3.0/#/zh-cn/command
     */
    public function collect(): void
    {
        // 异步协程处理
        co(function () {
            $command = 'collect:permissions';
            $params = ['command' => $command];

            $input = new ArrayInput($params);
            $output = new NullOutput();

            /* @var $application Application */
            $application = $this->container->get(ApplicationInterface::class);
            $application->setAutoExit(false);

            try {
                $application->find($command)->run($input, $output);
            } catch (ExceptionInterface $e) {
                throw new BusinessException($e->getMessage());
            }
        });
    }
}
