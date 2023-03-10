<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\TestActionTrail;
use Hyperf\Database\Model\SoftDeletes;

/**
 * 测试 - 模型.
 *
 * @property int    $id        自增 ID
 * @property string $name      用户名
 * @property string $phone     手机号
 * @property string $password  密码
 * @property string $status    状态 ( enable-启用 disable-禁用 )
 * @property Carbon $createdAt 创建时间
 * @property Carbon $updatedAt 修改时间
 * @property Carbon $deletedAt 删除时间 ( 软删除 )
 */
class Test extends AbstractModel
{
    use SoftDeletes;
    use StatusTrait;
    use TestActionTrail;

    protected ?string $table = '_test';

    protected array $hidden = ['password'];

    protected array $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
