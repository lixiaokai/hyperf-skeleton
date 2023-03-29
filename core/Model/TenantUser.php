<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;

/**
 * 租户和用户关系 - 模型.
 *
 * @property int    $id        自增 ID
 * @property int    $tenantId  租户 ID
 * @property int    $userId    用户 ID
 * @property Carbon $createdAt 创建时间
 */
class TenantUser extends AbstractModel
{
    public const UPDATED_AT = null;

    protected ?string $table = 'tenant_user';

    protected array $fillable = ['id', 'tenant_id', 'user_id', 'created_at'];

    protected array $casts = ['id' => 'integer', 'tenant_id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime'];
}
