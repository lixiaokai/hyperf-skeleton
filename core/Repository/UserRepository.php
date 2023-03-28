<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Model\Tenant;
use Core\Model\User;
use Core\Model\UserAdmin;
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
            throw new NotFoundException('基础用户不存在');
        }
    }

    public function updateOrCreate(array $attributes, $values = []): Model|User
    {
        return $this->modelClass::updateOrCreate($attributes, $values);
    }

    /**
     * 绑定角色.
     */
    public function bindRoles(Tenant $tenant, UserAdmin $userAdmin, Collection $roles, string $appId): void
    {
        // 中间表额外的数据
        // [
        //   1 => ['tenant_id' => 1, 'app_id' => 'admin'],
        //   2 => ['tenant_id' => 1, 'app_id' => 'admin'],
        // ]
        $roleIds = $roles->pluck('id');
        $ids = $roleIds->combine(
            $roleIds->map(fn () => [
                'tenant_id' => $tenant->id,
                'app_id' => $appId,
            ])
        );

        $userAdmin->roles()->sync($ids->all());
    }
}
