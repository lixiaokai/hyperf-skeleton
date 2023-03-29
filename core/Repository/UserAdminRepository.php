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
 * @method Collection|UserAdmin[] getByIds(int[] $ids, string[] $columns = ['*'])
 * @method UserAdmin              create(array $data)
 * @method UserAdmin              update(UserAdmin $model, array $data)
 */
class UserAdminRepository extends AbstractRepository
{
    protected Model|string $modelClass = UserAdmin::class;

    public function getByPhone(string $phone): Model|UserAdmin
    {
        try {
            return $this->modelClass::where('phone', $phone)->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new NotFoundException('用户信息不存在');
        }
    }

    public function enable(UserAdmin $userAdmin): UserAdmin
    {
        $userAdmin->status = Status::ENABLE;
        $userAdmin->save();

        return $userAdmin;
    }

    public function disable(UserAdmin $userAdmin): UserAdmin
    {
        $userAdmin->status = Status::DISABLE;
        $userAdmin->save();

        return $userAdmin;
    }

    public function resetPassword(UserAdmin $userAdmin, string $password): UserAdmin
    {
        $userAdmin->user->password = $password; // 赋值会自动处理密码哈希

        return $userAdmin;
    }
}
