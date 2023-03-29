<?php

namespace HyperfTest\Model;

use Core\Model\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * @see App::tenants()
     */
    public function testTenants()
    {
        $app = App::find('admin');
        var_dump($app->tenants);

        self::assertTrue(true);
    }

    /**
     * @see App::tenants()
     */
    public function testUsers()
    {
        $app = App::find('admin');
        var_dump($app->users->toArray());

        self::assertTrue(true);
    }
}
