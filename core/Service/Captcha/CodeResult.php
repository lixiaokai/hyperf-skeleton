<?php

declare(strict_types=1);

namespace Core\Service\Captcha;

use Carbon\Carbon;

/**
 * 验证码 - 结果.
 *
 * @property string $code   验证码
 * @property int    $expire 过期时间
 */
class CodeResult
{
    public function __construct(public string $code, public int $expire)
    {
    }

    /**
     * 获取 - 过期时间.
     *
     * 例如：2020-10-10 10:10:10
     */
    public function getExpiredString(): string
    {
        return Carbon::now()->addSeconds($this->expire)->toDateTimeString();
    }
}
