<?php

namespace HyperfTest\Model;

use Core\Model\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    /**
     * @see Admin::user()
     */
    public function testUser()
    {
        $admin = Admin::find(1);
        var_dump($admin->user->toArray());

        self::assertTrue(true);
    }

    /**
     * @see Admin::roles()
     */
    public function testRoles()
    {
        $admin = Admin::find(1);
        var_dump($admin->roles->toArray());

        self::assertTrue(true);
    }

    /**
     * @see Admin::getPermissions()
     */
    public function testGetPermissions()
    {
        $admin = Admin::find(1);
        var_dump($admin->getPermissions()->toArray());

        self::assertTrue(true);
    }

    /**
     * @see Admin::getMenus()
     */
    public function testGetMenus()
    {
        $admin = Admin::find(1);
        var_dump($admin->getMenus()->toArray());

        self::assertTrue(true);
    }
}
