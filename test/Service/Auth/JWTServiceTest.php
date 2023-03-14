<?php

namespace HyperfTest\Service\Auth;

use Kernel\Service\Auth\JWTAuth;
use Kernel\Service\Auth\JWTPayload;
use PHPUnit\Framework\TestCase;

class JWTServiceTest extends TestCase
{
    /**
     * @see JWTAuth::encode()
     */
    public function testEncode()
    {
        $uid = 1;
        $JWToken = JWTAuth::encode(
            JWTPayload::make(['uid' => $uid])
        );
        $jwtPayload = JWTAuth::decode($JWToken->token);
        var_dump([
            '$JWToken' => $JWToken->token,
            '$jwtPayload->getIatString()' => $jwtPayload->getIatString(),
            '$jwtPayload->getExpString()' => $jwtPayload->getExpString(),
        ]);

        self::assertTrue(true);
    }
}
