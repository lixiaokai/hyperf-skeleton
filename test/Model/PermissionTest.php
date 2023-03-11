<?php

namespace HyperfTest\Model;

use Core\Model\Permission;
use PHPUnit\Framework\TestCase;

class PermissionTest extends TestCase
{
    /**
     * @see Permission::roles()
     */
    public function testRoles()
    {
        $permission = Permission::find(1);
        var_dump($permission->roles);

        self::assertTrue(true);
    }
}
