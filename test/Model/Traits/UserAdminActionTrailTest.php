<?php

namespace HyperfTest\Model\Traits;

use Core\Model\UserAdmin;
use PHPUnit\Framework\TestCase;

class UserAdminActionTrailTest extends TestCase
{
    /**
     * @see UserAdminActionTrail::can()
     */
    public function testCan()
    {
        $user = UserAdmin::find(1);
        $route = '';

        self::assertTrue($user->can($route));
        self::assertTrue(true);
    }

    /**
     * @see UserAdminActionTrail::isAdministrator()
     */
    public function testIsAdministrator()
    {
        $user = UserAdmin::find(1);
        $isAdministrator = $user->isAdministrator();

        self::assertIsBool($isAdministrator);
    }
}
