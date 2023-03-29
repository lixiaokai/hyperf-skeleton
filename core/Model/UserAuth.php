<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\UserAuthType;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户授权 - 模型.
 *
 * @property int     $id         自增 ID
 * @property int     $userId     用户 ID
 * @property string  $type       授权类型 ( @see UserAuthType::class )
 * @property ?string $identifier 身份标识 ( 密码登录时为 null )
 * @property string  $credential 授权凭证 ( 本地密码 | 第三方 token )
 * @property Carbon  $createdAt  创建时间
 * @property Carbon  $updatedAt  修改时间
 *
 * @property string $password 本地密码
 * @property string $typeText 授权类型 - 文字
 */
class UserAuth extends AbstractModel
{
    protected ?string $table = 'user_auth';

    protected array $hidden = [
        'credential',
    ];

    protected array $fillable = [
        'id',
        'user_id',
        'type',
        'identifier',
        'credential',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTypeTextAttribute(): string
    {
        return UserAuthType::getText($this->type);
    }

    public function getPasswordAttribute(): string
    {
        return $this->credential;
    }

    public function setPasswordAttribute(string $password): void
    {
        // 该方式是直接把纸给属性
        // $this->attributes['type'] = UserAuthType::PWD;
        // $this->attributes['credential'] = password_hash($password, PASSWORD_DEFAULT);

        // 该方式如果有 casts 类型转换，则会再次转换
        $this->type = UserAuthType::PWD;
        $this->credential = password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->credential);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
