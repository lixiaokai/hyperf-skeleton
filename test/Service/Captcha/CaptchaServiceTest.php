<?php

namespace HyperfTest\Service\Captcha;

use Core\Constants\CaptchaType;
use Core\Service\Captcha\CaptchaService;
use Exception;
use PHPUnit\Framework\TestCase;

class CaptchaServiceTest extends TestCase
{
    protected CaptchaService $service;

    protected string $mobile = '13800138000';

    public function setUp(): void
    {
        parent::setUp();
        $this->service = make(CaptchaService::class);
    }

    public function testGetCodeByCache(): void
    {

    }

    public function testCheckCode(): void
    {

    }

    /**
     * @throws Exception
     * @see CaptchaService::genCode()
     */
    public function testGenCode(): void
    {
        $code = $this->service->genCode($this->mobile, CaptchaType::LOGIN);
        var_dump($code);

        self::assertTrue(true);
    }

    /**
     * @see CaptchaService::canRenewGenCode()
     */
    public function testCanRenewGenCode(): void
    {
        $res = $this->service->canRenewGenCode($this->mobile, CaptchaType::LOGIN);
        var_dump($res);

        self::assertTrue(true);
    }

    public function testDelCodeByCache(): void
    {

    }
}
