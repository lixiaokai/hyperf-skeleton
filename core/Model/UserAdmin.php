<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\Platform;
use Core\Constants\Status;
use Core\Contract\UserInterface;
use Core\Model\Casts\PasswordHash;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\UserAdminActionTrail;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Utils\Collection as UCollection;
use Kernel\Service\Auth\JWTAuth;
use Kernel\Service\Auth\JWToken;

/**
 * 总后台用户 - 模型.
 *
 * @property int     $id        自增 ID
 * @property int     $userId    用户 ID
 * @property ?string $name      用户名
 * @property string  $phone     手机号
 * @property ?string $password  密码
 * @property string  $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon  $createdAt 创建时间
 * @property Carbon  $updatedAt 修改时间
 *
 * @property User              $user  基础用户
 * @property Collection|Role[] $roles 角色 ( 多条 )
 */
class UserAdmin extends AbstractModel implements UserInterface
{
    use StatusTrait;
    use UserAdminActionTrail;

    protected ?string $table = 'user_admin';

    protected array $hidden = [
        'password',
    ];

    protected array $fillable = [
        'id',
        'user_id',
        'name',
        'phone',
        'password',
        'status',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'password' => PasswordHash::class,
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
        // 1. 获取所有启用的菜单
        $menus = Menu::query()
            ->where(Menu::column('platform'), Platform::ADMIN)
            ->where(Menu::column('status'), Status::ENABLE)
            ->get();

        // 2. 如果不是超管
        if (! $this->isAdministrator()) {
            // 2.1. 获取我的权限路由
            $routes = $this->getPermissions()->pluck('route');

            // 2.2. 获取有权限路由的菜单 ( 集合 where 时会保留索引，这里去掉索引 )
            $menus = $menus->whereIn('route', $routes)->values();
        }

        return $menus;
    }

    /**
     * 获取 - JWT.
     */
    public function getJWToken(int $daysExp = 14): JWToken
    {
        return JWTAuth::token($this->userId, $daysExp);
    }

    /**
     * @see AdminTest::testUser()
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @see AdminTest::testRoles()
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id', 'user_id')
            ->wherePivot('platform', Platform::ADMIN); // 注意：这里需要加上 [ 所属平台 ] 过滤以区分开来
        // ->where(Role::column('platform'), Platform::ADMIN);
        // 注意：这里必须使用中间表过滤关系，否则使用多对多关联 sync() 等方法更新时只会根据 user_id 查出记录
    }
}
