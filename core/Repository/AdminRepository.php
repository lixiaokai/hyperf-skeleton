<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Model\Admin;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

/**
 * 总后台用户 - 仓库类.
 *
 * @method Admin              getById(int $id)
 * @method Admin[]|Collection getByIds(array $ids, array $columns = ['*'])
 * @method Admin              create(array $data)
 * @method Admin              update(Admin $model, array $data)
 */
class AdminRepository extends AbstractRepository
{
    protected Model|string $modelClass = Admin::class;
}
