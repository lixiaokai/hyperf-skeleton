<?php

declare(strict_types=1);

namespace Kernel\Service\Auth;

/**
 * JWToken 数据对象.
 */
class JWToken
{
    public function __construct(
        public string $token,
        public JWTPayload $payload
    ) {
    }

    public static function make(string $token, JWTPayload $payload): self
    {
        return new static($token, $payload);
    }
}
