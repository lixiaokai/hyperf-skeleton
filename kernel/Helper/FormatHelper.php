<?php

namespace Kernel\Helper;

use Carbon\Carbon;

/**
 * 数据格式化器 - 助手类.
 */
class FormatHelper
{
    /**
     * 日期转字符串.
     */
    public static function toDateString(?Carbon $dt, ?string $default = ''): string
    {
        return $dt?->format('Y-m-d') ?? $default;
    }

    /**
     * 日期时间转字符串.
     */
    public static function toDateTimeString(?Carbon $dt, ?string $default = ''): string
    {
        return $dt?->toDateTimeString() ?? $default;
    }
}
