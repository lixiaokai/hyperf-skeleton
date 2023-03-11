<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\Platform;
use Core\Constants\Status;
use Core\Model\Traits\AdminActionTrail;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Utils\Collection as UCollection;

/**
 * 总后台用户 - 模型.
 *
 * @property int         $id        用户 ID
 * @property null|string $name      用户名
 * @property string      $phone     手机号
 * @property Carbon      $createdAt 创建时间
 * @property Carbon      $updatedAt 修改时间
 *
 * @property User              $user  基础用户
 * @property Collection|Role[] $roles 角色 ( 多条 )
 */
class Admin extends AbstractModel
{
    use AdminActionTrail;

    protected ?string $table = 'admin';

    protected array $fillable = [
        'id',
        'name',
        'phone',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 获取 - 用户权限.
     *
     * @see AdminTest::testGetPermissions()
     * @return Permission[]|UCollection
     */
    public function getPermissions(): array|UCollection
    {
        return $this->roles()
            ->where(Role::column('status'), Status::ENABLE) // 状态：启用
            ->with('permissions') // 预加载获取权限
            ->get() // 获取集合
            ->pluck('permissions') // 取出 key 等于 permissions 的所有值
            ->flatten() // 多维转一维
            ->unique('id'); // 去重
    }

    /**
     * 获取 - 用户菜单.
     *
     * @see AdminTest::testGetMenus()
     * @return Menu[]|UCollection
     */
    public function getMenus(): array|UCollection
    {
        $routes = $this->getPermissions()->pluck('route');

        return Menu::query()
            ->where(Menu::column('platform'), Platform::ADMIN)
            ->where(Menu::column('status'), Status::ENABLE)
            ->get()
            ->whereIn('route', $routes);
    }

    /**
     * @see AdminTest::testUser()
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * @see AdminTest::testRoles()
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')
            ->where(Role::column('platform'), Platform::ADMIN); // 注意：这里需要加上 [ 所属平台 ] 过滤以区分开来
    }
}
