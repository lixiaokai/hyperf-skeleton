<?php

namespace HyperfTest\Service\Auth;

use Kernel\Service\Auth\JWTAuth;
use PHPUnit\Framework\TestCase;

class JWTServiceTest extends TestCase
{
    /**
     * @see JWTAuth::encode()
     */
    public function testEncode()
    {
        $uid = 1;
        $jwtToken = JWTAuth::encode($uid);
        $jwtPayload = JWTAuth::decode($jwtToken);
        var_dump([
            '$jwtToken' => $jwtToken,
            '$jwtPayload' => $jwtPayload,
        ]);

        self::assertTrue(true);
    }
}
