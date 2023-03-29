<?php

namespace HyperfTest\Model;

use Core\Model\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{

    public function testMenus()
    {

    }

    /**
     * @see Role::userAdmins()
     */
    public function testUserAdmins()
    {
        $role = Role::find(1);
        var_dump($role->userAdmins->toArray());

        self::assertTrue(true);
    }

    /**
     * @see Role::tenants()
     */
    public function testTenants()
    {
        $role = Role::find(1);
        var_dump($role->tenants->toArray());

        self::assertTrue(true);
    }

    public function testPermissions()
    {

    }

    public function testUsers()
    {

    }
}
