<?php

declare(strict_types=1);

namespace Core\Model;


use Carbon\Carbon;

/**
 * 应用和租户关系 - 模型.
 *
 * @property int    $id        自增 ID
 * @property int    $appId     应用 ID
 * @property int    $userId    用户 ID
 * @property Carbon $createdAt 创建时间
 */
class AppUser extends AbstractModel
{
    public const UPDATED_AT = null;

    protected ?string $table = 'app_user';

    protected array $fillable = ['id', 'app_id', 'user_id', 'created_at'];

    protected array $casts = ['id' => 'integer', 'app_id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime'];
}
