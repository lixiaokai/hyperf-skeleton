<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Model\Traits\MenuActionTrail;
use Core\Model\Traits\StatusTrait;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * 菜单 - 模型.
 *
 * @property int    $id        权限菜单 ID
 * @property int    $parentId  父 ID
 * @property string $appId     应用 ID
 * @property string $path      前端路由
 * @property string $route     后端路由
 * @property string $name      名称
 * @property string $desc      描述
 * @property string $icon      图标
 * @property string $status    状态 ( enable-启用 disabled-禁用 )
 * @property int    $sort      排序
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 *
 * @property Collection|Role[] $roles 角色 ( 多条 )
 */
class Menu extends AbstractModel
{
    use StatusTrait;
    use MenuActionTrail;

    protected ?string $table = 'menu';

    protected array $fillable = [
        'id',
        'parent_id',
        'app_id',
        'path',
        'route',
        'name',
        'desc',
        'icon',
        'status',
        'sort',
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
