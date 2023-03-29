<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * 应用 - 模型.
 *
 * @property string $id        应用 ID
 * @property string $name      应用名称
 * @property ?array $data      应用数据 Json
 * @property int    $sort      排序
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 *
 * @property Collection|Tenant[] $tenants 租户 ( 多条 )
 */
class App extends AbstractModel
{
    public bool $incrementing = false; // 无自增

    protected ?string $table = 'app';

    protected string $keyType = 'string'; // 主键为字符串

    protected array $fillable = ['id', 'name', 'data', 'sort', 'created_at', 'updated_at'];

    protected array $casts = ['sort' => 'integer', 'data' => 'json', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * @see AppTest::testTenants()
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}
