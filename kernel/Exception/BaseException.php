<?php

declare(strict_types=1);

namespace Kernel\Exception;

use Kernel\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;

/**
 * 异常 - 抽象基类.
 */
abstract class BaseException extends ServerException
{
    public function __construct(?string $message = null, int $code = 0, \Throwable $previous = null)
    {
        is_null($message) && $message = ErrorCode::getMessage($code);
        parent::__construct($message, $code, $previous);
    }
}
