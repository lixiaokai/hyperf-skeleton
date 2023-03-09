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
    public static function toDateString(Carbon|string $dt, ?string $default = ''): ?string
    {
        return $dt instanceof Carbon ? $dt->format('Y-m-d') : (is_string($dt) ? $dt : $default);
    }

    /**
     * 日期时间转字符串.
     */
    public static function toDateTimeString(Carbon|string $dt, ?string $default = ''): ?string
    {
        return $dt instanceof Carbon ? $dt->format('Y-m-d H:i:s') : (is_string($dt) ? $dt : $default);
    }
}
