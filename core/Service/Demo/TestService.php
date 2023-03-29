<?php

namespace Core\Service\Demo;

use Core\Exception\BusinessException;
use Core\Model\Test;
use Core\Repository\TestRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\NotFoundException;

/**
 * 测试 - 服务类.
 */
class TestService extends AbstractService
{
    #[Inject]
    protected TestRepository $repo;

    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery()->orderByDesc('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 详情.
     */
    public function getById(int $id): Test
    {
        try {
            $test = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new NotFoundException('测试信息不存在');
        }

        return $test;
    }

    /**
     * 创建.
     */
    public function create(array $data): Test
    {
        return $this->repo->create($data);
    }

    /**
     * 修改.
     */
    public function update(Test $test, array $data): Test
    {
        if (! $test->canUpdate()) {
            throw new BusinessException('不允许修改');
        }

        return $this->repo->update($test, $data);
    }

    /**
     * 删除.
     */
    public function delete(Test $test): bool
    {
        if (! $test->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($test);
    }

    /**
     * 启用.
     */
    public function enable(Test $test): Test
    {
        return $this->repo->enable($test);
    }

    /**
     * 禁用.
     */
    public function disable(Test $test): Test
    {
        return $this->repo->disable($test);
    }
}
