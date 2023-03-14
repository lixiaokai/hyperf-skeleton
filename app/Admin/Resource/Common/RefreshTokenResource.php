<?php

declare(strict_types=1);

namespace App\Admin\Resource\Common;

use Core\Model\User;
use Core\Resource\AbstractResource;

/**
 * 用户 - 刷新令牌 - 资源.
 *
 * @property User $resource
 */
class RefreshTokenResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'uid' => $this->resource->id, // 用户 id
            'accessToken' => $this->resource->JWToken->token, // 访问令牌
            'accessTokenTimeout' => $this->resource->JWToken->payload->getExpString(), // 过期时间
        ];
    }
}
