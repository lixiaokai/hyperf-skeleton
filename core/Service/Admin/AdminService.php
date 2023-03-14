<?php

declare(strict_types=1);

namespace Core\Service\Admin;

use Core\Exception\BusinessException;
use Core\Model\Admin;
use Core\Repository\AdminRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 总后台用户 - 服务类.
 */
class AdminService extends AbstractService
{
    #[Inject]
    protected AdminRepository $repo;

    /**
     * 总后台用户 - 列表.
     */
    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery()->with('user');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 总后台用户 - 详情.
     */
    public function getById(int $id): Admin
    {
        try {
            $admin = $this->repo->getById($id);
        } catch (BusinessException) {
            throw new BusinessException('该用户不存在');
        }

        return $admin;
    }

    /**
     * 总后台用户 - 创建.
     */
    public function create(array $data): Admin
    {
        return $this->repo->create($data);
    }

    /**
     * 总后台用户 - 修改.
     */
    public function update(Admin $admin, array $data): Admin
    {
        return $this->repo->update($admin, $data);
    }
}
