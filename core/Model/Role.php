<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\RoleType;
use Core\Model\Traits\RoleActionTrail;
use Core\Model\Traits\StatusTrait;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * 角色 - 模型.
 *
 * @property int    $id        角色 ID
 * @property int    $parentId  父 ID
 * @property string $platform  终端平台 ( @see \Core\Constants\Platform::class )
 * @property string $type      类型 ( @see \Core\Constants\RoleType::class )
 * @property string $name      名称
 * @property string $remark    备注
 * @property int    $sort      排序
 * @property string $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 *
 * @property string $typePlatformKey 类型所属终端平台 - key
 * @property string $typeText        类型 - 文字
 *
 * @property Role                    $parent      父级角色
 * @property Collection|Role[]       $children    子级角色 ( 多条 )
 * @property Collection|Role[]       $siblings    同级角色 ( 多条 )
 * @property Collection|Menu[]       $menus       菜单 ( 多条 )
 * @property Collection|Permission[] $permissions 权限 ( 多条 )
 * @property Collection|User[]       $users       用户 ( 多条 )
 * @property UserAdmin[]|Collection      $admins      总后台用户 ( 多条 )
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

    protected array $fillable = [
        'id',
        'parent_id',
        'platform',
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

    public function getTypePlatformKeyAttribute(): string
    {
        return RoleType::getPlatformKey($this->type);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function siblings(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'parent_id');
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'role_menu');
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
     * @see RoleTest::testAdmins()
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(UserAdmin::class, 'role_user', 'role_id', 'user_id');
    }
}
