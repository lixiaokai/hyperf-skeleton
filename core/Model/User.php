<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\UserActionTrail;
use Core\Model\Traits\UserAuthTrail;

/**
 * 基础用户 - 模型.
 *
 * 即所有用户的基础表
 *
 * @property int    $id        用户 ID
 * @property string $name      用户名
 * @property string $phone     手机号
 * @property string $password  密码
 * @property string $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 */
class User extends AbstractModel
{
    use StatusTrait;
    use UserActionTrail;
    use UserAuthTrail;

    protected ?string $table = 'user';

    protected array $hidden = [
        'password',
    ];

    protected array $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'status',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
