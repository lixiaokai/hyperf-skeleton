<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\UserType;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * 应用 - 模型.
 *
 * @property string $id        应用 ID
 * @property string $userType  用户类型 ( 该应用支持的用户类型 @see UserType::class )
 *                             暂时用于标记作用
 * @property string $name      应用名称
 * @property string $desc      应用描述
 * @property ?array $data      应用数据 Json
 * @property int    $sort      排序
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 *
 * @property string $userTypeText 用户类型 - 文字
 *
 * @property Collection|Tenant[] $tenants 租户 ( 多条 )
 * @property Collection|User[]   $users   用户 ( 多条 )
 */
class App extends AbstractModel
{
    public bool $incrementing = false; // 无自增

    protected ?string $table = 'app';

    protected string $keyType = 'string'; // 主键为字符串

    protected array $attributes = [
        'user_type' => UserType::ADMIN,
    ];

    protected array $fillable = [
        'id',
        'user_type',
        'name',
        'desc',
        'data',
        'sort',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'sort' => 'integer',
        'data' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getUserTypeTextAttribute(): string
    {
        return UserType::getText($this->userType);
    }

    /**
     * @see AppTest::testTenants()
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    /**
     * @see AppTest::testUsers()
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
