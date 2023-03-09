<?php

declare(strict_types=1);

namespace Kernel\Constants;

/**
 * 常量收集器 - 扩展类.
 */
class ConstantsCollector extends \Hyperf\Constants\ConstantsCollector
{
    public static function getValues($className): array
    {
        return array_keys(static::$container[$className] ?? []);
    }

    public static function getValueData($className): array
    {
        return static::$container[$className] ?? [];
    }
}
