<?php

declare(strict_types=1);

namespace App\Admin\Resource\Public;

use Core\Model\UserAdmin;
use Core\Resource\AbstractResource;

/**
 * 用户登录 - 资源.
 *
 * @property UserAdmin $resource
 */
class LoginResource extends AbstractResource
{
    public function toArray(): array
    {
        $JWToken = $this->resource->getJWToken();

        return [
            'uid' => $this->resource->userId, // 用户 id
            'accessToken' => $JWToken->token, // 访问令牌
            'accessTokenTimeout' => $JWToken->payload->getExpString(), // 过期时间
        ];
    }
}
