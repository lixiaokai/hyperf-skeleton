<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\TenantActionTrail;

/**
 * 租户 - 模型.
 *
 * @property int    $id        租户 ID
 * @property string $name      租户名称
 * @property ?array $data      租户数据
 * @property string $status    状态 ( init-初始化 enable-启用 disable-禁用 )
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 */
class Tenant extends AbstractModel
{
    use StatusTrait;
    use TenantActionTrail;

    protected ?string $table = 'tenant';

    protected array $fillable = ['id', 'name', 'data', 'status', 'created_at', 'updated_at'];

    protected array $casts = ['id' => 'integer', 'data' => 'json', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
