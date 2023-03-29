<?php

namespace HyperfTest\Model;

use Core\Model\UserAdmin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    /**
     * @see UserAdmin::user()
     */
    public function testUser()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->user->toArray());

        self::assertTrue(true);
    }

    /**
     * @see UserAdmin::apps()
     */
    public function testApps()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->apps->toArray());

        self::assertTrue(true);
    }

    /**
     * @see UserAdmin::tenants()
     */
    public function testTenants()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->tenants->toArray());

        self::assertTrue(true);
    }

    /**
     * @see UserAdmin::roles()
     */
    public function testRoles()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->roles->toArray());

        self::assertTrue(true);
    }

    /**
     * @see UserAdmin::getPermissions()
     */
    public function testGetPermissions()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->getPermissions()->toArray());

        self::assertTrue(true);
    }

    /**
     * @see UserAdmin::getMenus()
     */
    public function testGetMenus()
    {
        $admin = UserAdmin::find(1);
        var_dump($admin->getMenus()->toArray());

        self::assertTrue(true);
    }
}
