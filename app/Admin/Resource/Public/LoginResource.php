<?php

declare(strict_types=1);

namespace App\Admin\Resource\Public;

use Core\Model\User;
use Core\Resource\AbstractResource;

/**
 * 用户登录 - 资源.
 *
 * @property User $resource
 */
class LoginResource extends AbstractResource
{
    public function toArray(): array
    {
        $JWToken = $this->resource->getJWToken();

        return [
            'id' => $this->resource->id, // 用户 id
            'accessToken' => $JWToken->token, // 访问令牌
            'accessTokenTimeout' => $JWToken->payload->getExpString(), // 过期时间
        ];
    }
}
