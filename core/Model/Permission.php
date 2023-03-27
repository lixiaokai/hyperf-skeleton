<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Model\Traits\PermissionActionTrail;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\SoftDeletes;
use Yadakhov\InsertOnDuplicateKey;

/**
 * 权限 - 模型.
 *
 * @property int     $id           权限菜单 ID
 * @property int     $parentId     父 ID
 * @property string  $appId        应用 ID
 * @property string  $route        路由 ( method + route 组成 )
 * @property ?string $attachRoutes 附加路由
 * @property string  $name         名称
 * @property string  $desc         描述
 * @property int     $sort         排序
 * @property Carbon  $createdAt    创建时间
 * @property Carbon  $updatedAt    修改时间
 * @property ?Carbon $deletedAt    删除时间 ( 软删除 )
 *
 * @property Collection|Role[] $roles 角色 ( 多条 )
 */
class Permission extends AbstractModel
{
    use PermissionActionTrail;
    use SoftDeletes;
    use InsertOnDuplicateKey;

    protected ?string $table = 'permission';

    protected array $fillable = [
        'id',
        'parent_id',
        'app_id',
        'route',
        'attach_routes',
        'name',
        'desc',
        'sort',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'attach_routes' => 'json',
        'sort' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @see PermissionTest::testRoles()
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
