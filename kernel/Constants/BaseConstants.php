<?php

declare(strict_types=1);

namespace Kernel\Constants;

use Hyperf\Constants\AbstractConstants;

/**
 * 枚举常量 - 抽象基类.
 */
abstract class BaseConstants extends AbstractConstants
{
    /**
     * 获取 - 所有常量.
     */
    public static function codes(): array
    {
        return ConstantsCollector::getValues(static::class);
    }

    /**
     * 获取 - 枚举字典 ( 根据注解名获取数组 ).
     *
     * @example
     * ```
     * self::dict('text')
     * ```
     */
    public static function dict(string $with, array $map = []): array
    {
        [$k, $v] = $map + ['key', 'value'];
        $method = "get{$with}";
        return array_map(static fn ($key) => [
            $k => $key,
            $v => call_user_func([static::class, $method], $key),
        ], static::codes());
    }

    /**
     * 是否 - 存在该常量.
     *
     * @param mixed $code 常量值
     */
    public static function has(mixed $code): bool
    {
        return in_array($code, static::codes(), true);
    }
}
