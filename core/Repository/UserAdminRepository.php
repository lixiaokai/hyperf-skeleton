<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Status;
use Core\Model\UserAdmin;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\ModelNotFoundException;
use Kernel\Exception\NotFoundException;

/**
 * 总后台用户 - 仓库类.
 *
 * @method UserAdmin              getById(int $id)
 * @method Collection|UserAdmin[] getByIds(array $ids, array $columns = ['*'])
 * @method UserAdmin              create(array $data)
 * @method UserAdmin              update(UserAdmin $model, array $data)
 */
class UserAdminRepository extends AbstractRepository
{
    protected Model|string $modelClass = UserAdmin::class;

    /**
     * 总后台用户 - 详情.
     */
    public function getByUserId(int $userId, array $columns = ['*']): Model|UserAdmin
    {
        try {
            return $this->modelClass::where('user_id', $userId)->firstOrFail($columns);
        } catch (ModelNotFoundException) {
            throw new NotFoundException('用户信息不存在');
        }
    }

    /**
     * 总后台用户 - 启用.
     */
    public function enable(UserAdmin $userAdmin): UserAdmin
    {
        $userAdmin->status = Status::ENABLE;
        $userAdmin->save();

        return $userAdmin;
    }

    /**
     * 总后台用户 - 禁用.
     */
    public function disable(UserAdmin $userAdmin): UserAdmin
    {
        $userAdmin->status = Status::DISABLE;
        $userAdmin->save();

        return $userAdmin;
    }
}
