<?php

declare(strict_types=1);

namespace Kernel\Exception;

use Throwable;

class DataSaveException extends AbstractException
{
    public function __construct(string $message = '数据保存异常', int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
