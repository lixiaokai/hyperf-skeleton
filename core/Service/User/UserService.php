<?php

namespace Core\Service\User;

use Core\Exception\BusinessException;
use Core\Exception\NotFoundException;
use Core\Model\User;
use Core\Repository\UserRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户 - 服务类.
 */
class UserService extends AbstractService
{
    #[Inject]
    protected UserRepository $repo;

    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery();

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 用户 - 详情 ( 根据 ID ).
     */
    public function getById(int $id): User
    {
        try {
            $user = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new NotFoundException('用户信息不存在');
        }

        return $user;
    }

    /**
     * 用户 - 详情 ( 根据手机号 ).
     */
    public function getByPhone(string $phone): User
    {
        try {
            $user = $this->repo->getByPhone($phone);
        } catch (NotFoundException) {
            throw new NotFoundException('用户信息不存在');
        }

        return $user;
    }

    /**
     * 用户 - 创建.
     */
    public function create(array $data): User
    {
        return $this->repo->create($data);
    }

    /**
     * 用户 - 修改.
     */
    public function update(User $user, array $data): User
    {
        if (! $user->canUpdate()) {
            throw new BusinessException('不允许修改');
        }

        return $this->repo->update($user, $data);
    }

    /**
     * 用户 - 删除.
     */
    public function delete(User $user): bool
    {
        if (! $user->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($user);
    }
}
