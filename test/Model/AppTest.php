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
}
