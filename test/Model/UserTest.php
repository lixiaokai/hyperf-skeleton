<?php

namespace HyperfTest\Model;

use Core\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testRoles()
    {
        $user = User::find(1);
        $user->roles;

        self::assertTrue(true);
    }
}
