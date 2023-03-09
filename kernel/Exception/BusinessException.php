<?php

declare(strict_types=1);

namespace Kernel\Exception;

class BusinessException extends BaseException
{
    public function __construct(?string $message = '业务异常', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
