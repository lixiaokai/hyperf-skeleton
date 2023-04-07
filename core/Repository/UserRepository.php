<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Model\Tenant;
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
            throw new NotFoundException('用户不存在');
        }
    }

    public function getByUsername(string $username): Model|User
    {
        try {
            return $this->modelClass::where('username', $username)->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new NotFoundException('用户不存在');
        }
    }

    public function getByEmail(string $email): Model|User
    {
        try {
            return $this->modelClass::where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new NotFoundException('用户不存在');
        }
    }

    public function updateOrCreate(array $attributes, $values = []): Model|User
    {
        return $this->modelClass::updateOrCreate($attributes, $values);
    }

    /**
     * 绑定角色.
     */
    public function bindRoles(Tenant $tenant, User $user, Collection $roles, string $appId): void
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

        $user->roles()->sync($ids->all());
    }

    /**
     * 绑定应用.
     */
    public function bindApp(User $user, string $appId): void
    {
        $user->apps()->attach($appId);
    }

    /**
     * 绑定租户.
     */
    public function bindTenant(User $user, Tenant $tenant): void
    {
        $user->tenants()->attach($tenant->id);
    }
}
