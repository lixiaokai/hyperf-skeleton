<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\ContextKey;
use Core\Constants\UserAuthType;
use Core\Contract\UserInterface;
use Core\Model\Traits\StatusTrait;
use Core\Model\Traits\UserActionTrail;
use Hyperf\Context\Context;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\HasOne;
use Kernel\Service\Auth\JWTAuth;
use Kernel\Service\Auth\JWToken;

/**
 * 基础用户 - 模型.
 *
 * 即所有用户的基础表
 *
 * @property int     $id        用户 ID
 * @property string  $username  用户账号
 * @property ?string $nickname  用户昵称
 * @property ?string $phone     手机号码
 * @property string  $status    用户状态 ( enable-启用 disable-禁用 )
 * @property Carbon  $createdAt 创建时间
 * @property Carbon  $updatedAt 修改时间
 *
 * @property UserAdmin             $userAdmin 总后台用户
 * @property UserAuth              $password  本地密码
 * @property Collection|UserAuth[] $auths     用户授权 ( 多条 )
 * @property App[]|Collection      $apps      应用 ( 多条 )
 * @property Collection|Tenant[]   $tenants   租户 ( 多条 )
 * @property Collection|Role[]     $roles     角色 ( 多条 )
 */
class User extends AbstractModel implements UserInterface
{
    use StatusTrait;
    use UserActionTrail;

    protected ?string $table = 'user';

    protected array $fillable = [
        'id',
        'username',
        'nickname',
        'phone',
        'status',
        'created_at',
        'updated_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 获取 - JWT.
     */
    public function getJWToken(int $daysExp = 14): JWToken
    {
        return JWTAuth::token($this->id, $daysExp);
    }

    /**
     * 设置密码 - 修改器.
     */
    public function setPasswordAttribute(?string $password)
    {
        // 空密码不处理
        if (! $password) {
            return;
        }

        $userAuth = $this->password ?? new UserAuth(['userId' => $this->id]);
        $userAuth->password = $password; // 赋值会自动处理密码哈希
        $userAuth->save();
    }

    /**
     * 获取密码.
     */
    public function password(): HasOne
    {
        return $this->hasOne(UserAuth::class)->where(UserAuth::column('type'), UserAuthType::PWD);
    }

    public function userAdmin(): HasOne
    {
        return $this->hasOne(UserAdmin::class, 'id', 'id');
    }

    public function auths(): HasMany
    {
        return $this->hasMany(UserAuth::class);
    }

    public function apps(): BelongsToMany
    {
        return $this->belongsToMany(App::class);
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    /**
     * 获取 - 某租户的角色 ( 多条 ).
     */
    public function roles(): BelongsToMany
    {
        $relation = $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');

        // 如果注入了租户 ID，则把租户 ID 作为中间表查询条件
        if ($tenantId = Context::get(ContextKey::TENANT_ID)) {
            $relation->wherePivot('tenant_id', '=', $tenantId);
        }

        return $relation;
    }
}
