<?php

declare(strict_types=1);

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

    /**
     * 字节数转可读性字符串.
     *
     * @param  int    $bytes    文件大小 ( 字节数 )
     * @param  int    $decimals 保留多少位小数
     * @return string 带单位的文件大小字符串
     */
    public static function bytesToString(int $bytes, int $decimals = 2): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        $key = floor((strlen((string) $bytes) - 1) / 3); // 舍去法取整

        $unit = @$units[$key]; // 单位
        $fileSize = sprintf("%.{$decimals}f", $bytes / pow(1024, $key)); // 字节大小

        return $fileSize . ' ' . $unit;
    }
}
