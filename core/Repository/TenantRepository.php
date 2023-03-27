<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Status;
use Core\Model\Tenant;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

/**
 * 租户 - 仓库类.
 *
 * @method Tenant              getById(int $id)
 * @method Collection|Tenant[] getByIds(array $ids, array $columns = ['*'])
 * @method Tenant              create(array $data)
 * @method Tenant              update(Tenant $model, array $data)
 */
class TenantRepository extends AbstractRepository
{
    protected Model|string $modelClass = Tenant::class;

    /**
     * 租户 - 启用.
     */
    public function enable(Tenant $tenant): Tenant
    {
        $tenant->status = Status::ENABLE;
        $tenant->save();

        return $tenant;
    }

    /**
     * 租户 - 禁用.
     */
    public function disable(Tenant $tenant): Tenant
    {
        $tenant->status = Status::DISABLE;
        $tenant->save();

        return $tenant;
    }
}
