<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;

/**
 * 租户和角色关系 - 模型.
 *
 * @property int    $id        自增 ID
 * @property int    $tenantId  租户 ID
 * @property int    $roleId    角色 ID
 * @property Carbon $createdAt 创建时间
 */
class TenantRole extends AbstractModel
{
    public const UPDATED_AT = null;

    protected ?string $table = 'tenant_role';

    protected array $fillable = ['id', 'tenant_id', 'role_id', 'created_at'];

    protected array $casts = ['id' => 'integer', 'tenant_id' => 'integer', 'role_id' => 'integer', 'created_at' => 'datetime'];
}
