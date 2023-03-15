<?php

namespace Kernel\Exception\Format;

use Throwable;

/**
 * 错误消息 - 格式.
 */
class ExceptionMessage
{
    public static function format(Throwable $t): string
    {
        return sprintf('%s[%s] in %s', $t->getMessage(), $t->getLine(), $t->getFile());
    }
}
