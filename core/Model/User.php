<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Contract\UserInterface;
use Core\Model\Casts\PasswordHash;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\UserActionTrail;
use Core\Model\Traits\UserAuthTrail;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasOne;

/**
 * 基础用户 - 模型.
 *
 * 即所有用户的基础表
 *
 * @property int     $id        用户 ID
 * @property ?string $name      用户名
 * @property string  $phone     手机号
 * @property string  $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon  $createdAt 创建时间
 * @property Carbon  $updatedAt 修改时间
 *
 * @property UserAdmin         $userAdmin 总后台用户
 * @property Collection|Role[] $roles     角色 ( 多条 )
 */
class User extends AbstractModel implements UserInterface
{
    use StatusTrait;
    use UserActionTrail;
    use UserAuthTrail;

    protected ?string $table = 'user';

    protected array $fillable = [
        'id',
        'name',
        'phone',
        'status',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function userAdmin(): HasOne
    {
        return $this->hasOne(UserAdmin::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
