<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\TenantStatus;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\TenantActionTrail;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * 租户 - 模型.
 *
 * @property int    $id        租户 ID
 * @property string $name      租户名称
 * @property ?array $data      租户数据
 * @property string $status    状态 ( waitInit-待初始化 enable-启用 disable-禁用 )
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 *
 * @property string $statusText 状态 - 文字
 *
 * @property App[]|Collection       $apps       应用 ( 多条 )
 * @property Collection|Role[]      $roles      角色 ( 多条 )
 * @property Collection|User[]      $users      基础用户 ( 多条 )
 * @property Collection|UserAdmin[] $userAdmins 总后台用户 ( 多条 )
 */
class Tenant extends AbstractModel
{
    use StatusTrait;
    use TenantActionTrail;

    protected ?string $table = 'tenant';

    protected array $attributes = [
        'status' => TenantStatus::WAIT_INIT,
    ];

    protected array $fillable = ['id', 'name', 'data', 'status', 'created_at', 'updated_at'];

    protected array $casts = ['id' => 'integer', 'data' => 'json', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function getStatusTextAttribute(): string
    {
        return TenantStatus::getText($this->status);
    }

    /**
     * @see TenantTest::testApps()
     */
    public function apps(): BelongsToMany
    {
        return $this->belongsToMany(App::class);
    }

    /**
     * @see TenantTest::testRoles()
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, TenantRole::table(), 'tenant_id', 'role_id');
    }

    /**
     * @see TenantTest::testUsers()
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @see TenantTest::testUserAdmins()
     */
    public function userAdmins(): BelongsToMany
    {
        return $this->belongsToMany(UserAdmin::class, TenantUser::table(), 'tenant_id', 'user_id');
    }
}
