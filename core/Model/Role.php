<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\RoleType;
use Core\Constants\Status;
use Core\Model\Traits\RoleActionTrail;
use Core\Model\Traits\StatusTrait;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * 角色 - 模型.
 *
 * 说明：角色和租户一般是 1 对多的关系，为了实现默认的系统角色可被多个租户使用，这里使用了多对多的关系
 *
 * @property int     $id        角色 ID
 * @property ?string $type      类型 ( @see RoleType::class )
 * @property string  $name      名称
 * @property string  $remark    备注
 * @property int     $sort      排序
 * @property string  $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon  $createdAt 创建时间
 * @property Carbon  $updatedAt 修改时间
 *
 * @property string $typeText 类型 - 文字
 *
 * @property Collection|Permission[] $permissions 权限 ( 多条 )
 * @property Collection|User[]       $users       用户 ( 多条 )
 * @property Collection|UserAdmin[]  $userAdmins  总后台用户 ( 多条 )
 * @property Collection|Tenant[]     $tenants     租户 ( 多条 )
 *
 * @see RoleTest::class
 */
class Role extends AbstractModel
{
    use StatusTrait;
    use RoleActionTrail;

    /**
     * 超级管理员角色 ID.
     *
     * 该角色拥有总后台所有权
     * 这里先写死，后面可改到配置中
     */
    public const ADMINISTRATOR_ROLE_ID = 1;

    protected ?string $table = 'role';

    protected array $attributes = [
        'type' => RoleType::CUSTOM,
        'status' => Status::ENABLE,
    ];

    protected array $fillable = [
        'id',
        'parent_id',
        'type',
        'name',
        'remark',
        'sort',
        'status',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'sort' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTypeTextAttribute(): string
    {
        return RoleType::getText($this->type);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @see RoleTest::testUserAdmins()
     */
    public function userAdmins(): BelongsToMany
    {
        return $this->belongsToMany(UserAdmin::class, RoleUser::table(), 'role_id', 'user_id');
    }

    /**
     * @see RoleTest::testTenants()
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, TenantRole::table(), 'role_id', 'tenant_id');
    }
}
