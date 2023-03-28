<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;

/**
 * 应用和租户关系 - 模型.
 *
 * @property int    $id        自增 ID
 * @property string $appId     应用 ID
 * @property int    $tenantId  租户 ID
 * @property Carbon $createdAt 创建时间
 */
class AppTenant extends AbstractModel
{
    public const UPDATED_AT = null;

    protected ?string $table = 'app_tenant';

    protected array $fillable = ['id', 'app_id', 'tenant_id', 'created_at'];

    protected array $casts = ['id' => 'integer', 'tenant_id' => 'integer', 'created_at' => 'datetime'];
}
