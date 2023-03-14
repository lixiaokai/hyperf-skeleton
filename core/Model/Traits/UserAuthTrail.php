<?php

namespace Core\Model\Traits;

use Kernel\Service\Auth\JWTAuth;
use Kernel\Service\Auth\JWToken;
use Kernel\Service\Auth\JWTPayload;

/**
 * @property JWToken $JWToken
 */
trait UserAuthTrail
{
    /**
     * 获取 - 用户 JWT token.
     */
    public function getJWTokenAttribute(): JWToken
    {
        static $jwToken;
        ! $jwToken && $jwToken = JWTAuth::encode(JWTPayload::make(['uid' => $this->id]));

        return $jwToken;
    }
}
