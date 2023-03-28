<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\ContextKey;
use Core\Contract\UserInterface;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\UserActionTrail;
use Hyperf\Context\Context;
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

    /**
     * 获取 - 某租户的角色 ( 多条 ).
     */
    public function roles(): BelongsToMany
    {
        $relation = $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');

        // 如果注入了租户 ID，则把租户 ID 作为中间表查询条件
        if ($tenantId = Context::get(ContextKey::TENANT_ID)) {
            $relation->wherePivot('tenant_id', '=', $tenantId);
        }

        return $relation;
    }
}
