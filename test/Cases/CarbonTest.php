<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * 时间处理类 - 测试.
 *
 * @internal
 * @coversNothing
 */
class CarbonTest extends TestCase
{
    public function test()
    {
        $res = [
            '获取当前时间方法 1' => Carbon::now()->toDateString(),
            '获取当前时间方法 2' => (new Carbon())->toDateString(),

            '前 7 天开始日期' => Carbon::now()->subDays(7)->toDateString(),
            '前 7 天的环比开始日期' => Carbon::now()->subDays(7)->subDays(7)->toDateString(),
            '昨天日期' => Carbon::yesterday()->toDateString(),
            '昨天日期时间' => Carbon::yesterday()->toDateTimeString(), // 2022-12-09 00:00:00 后面是 00:00:00
            '今天日期' => Carbon::now()->startOfDay()->toDateString(),

            '今天开始时间' => Carbon::now()->startOfDay()->toDateTimeString(), // 2022-10-21 00:00:00
            '今天结束时间' => Carbon::now()->endOfDay()->toDateTimeString(),   // 2022-10-21 23:59:59

            '上周开始日期' => Carbon::now()->subWeek()->startOfWeek()->toDateString(),
            '上周结束日期' => Carbon::now()->subWeek()->endOfWeek()->toDateString(),

            '解析时间 月头' => Carbon::parse('20220101')->startOfMonth()->toDateString(),
            '解析时间 月尾' => Carbon::parse('20220101')->endOfMonth()->toDateString(),

            '计算日期差' => Carbon::parse('2022-10-07')->diffInDays('2022-10-01'), // 6
            '增加日期' => Carbon::parse('2022-10-01')->addDays(6)->toDateString(), // 2022-10-07

            '间隔天数' => Carbon::now()->diffInDays('2022-11-10 17:00:00'),

            '日期比较 1' => '2022-10-21' > '2022-10-10', // true
            '日期比较 2' => '2022-10-21' > '2022-10-21', // false
            '日期比较 3' => '2022-10-21' == '2022-10-21', // true
            '日期比较 4' => '2022-10-21' > '2022-10-22', // false
        ];
        var_export($res);

        self::assertTrue(true);
    }
}
