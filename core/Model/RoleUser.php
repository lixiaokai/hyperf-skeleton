<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;

/**
 * 角色用户关系 - 模型.
 *
 * 角色、用户、租户、应用关系
 *
 * @property int    $id        自增 ID
 * @property int    $roleId    角色 ID
 * @property int    $userId    用户 ID
 * @property int    $tenantId  租户 ID
 * @property string $appId     应用 ID
 * @property Carbon $createdAt 创建时间
 */
class RoleUser extends AbstractModel
{
    public const UPDATED_AT = null;

    protected ?string $table = 'role_user';

    protected array $fillable = [
        'id',
        'role_id',
        'user_id',
        'tenant_id',
        'app_id',
        'created_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
        'user_id' => 'integer',
        'tenant_id' => 'integer',
        'created_at' => 'datetime',
    ];
}
