<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Model\User;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\ModelNotFoundException;
use Kernel\Exception\NotFoundException;

/**
 * 用户信息 - 仓库类.
 *
 * @method User              getById(int $id)
 * @method Collection|User[] getByIds(array $ids, array $columns = ['*'])
 * @method User              create(array $data)
 * @method User              update(User $model, array $data)
 */
class UserRepository extends AbstractRepository
{
    protected Model|string $modelClass = User::class;

    public function getByPhone(string $phone): Model|User
    {
        try {
            return $this->modelClass::where('phone', $phone)->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        }
    }
}
