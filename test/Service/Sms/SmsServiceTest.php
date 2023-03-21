<?php

namespace HyperfTest\Service\Sms;

use Core\Service\Sms\SmsService;
use Core\Service\Sms\Template\CaptchaMessage;
use PHPUnit\Framework\TestCase;

class SmsServiceTest extends TestCase
{
    /**
     * @see SmsService::send()
     */
    public function testSend()
    {
        $phone = '15800000000';
        $smsService = make(SmsService::class);
        $smsService->send($phone, new CaptchaMessage('0000'));

        self::assertTrue(true);
    }
}
