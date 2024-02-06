<?php

namespace HyperfTest\Service\Wechat;

use Core\Service\Wechat\WechatWorkService;
use PHPUnit\Framework\TestCase;

class WechatWorkServiceTest extends TestCase
{
    public function testOa()
    {
        $service = make(WechatWorkService::class);
        $service->test();

        self::assertTrue(true);
    }
}
