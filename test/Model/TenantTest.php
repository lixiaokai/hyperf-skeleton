<?php

namespace HyperfTest\Model;

use Core\Model\Tenant;
use PHPUnit\Framework\TestCase;

class TenantTest extends TestCase
{
    /**
     * @see Tenant::apps()
     */
    public function testApps()
    {
        $tenant = Tenant::find(1);
        var_dump($tenant->apps);

        self::assertTrue(true);
    }

    /**
     * @see Tenant::roles()
     */
    public function testRoles()
    {
        $tenant = Tenant::find(1);
        var_dump($tenant->roles->toArray());

        self::assertTrue(true);
    }

    /**
     * @see Tenant::users()
     */
    public function testUsers()
    {
        $tenant = Tenant::find(1);
        var_dump($tenant->users);

        self::assertTrue(true);
    }

    /**
     * @see Tenant::userAdmins()
     */
    public function testUserAdmins()
    {
        $tenant = Tenant::find(1);
        var_dump($tenant->userAdmins);

        self::assertTrue(true);
    }
}
