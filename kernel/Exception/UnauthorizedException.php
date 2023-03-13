<?php

declare(strict_types=1);

namespace Kernel\Exception;

class UnauthorizedException extends AbstractException
{
    public function __construct(string $message = '未经授权', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
