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
     * @see Role::admins()
     */
    public function testAdmins()
    {
        $role = Role::find(1);
        var_dump($role->admins->toArray());

        self::assertTrue(true);
    }

    public function testPermissions()
    {

    }

    public function testUsers()
    {

    }
}
