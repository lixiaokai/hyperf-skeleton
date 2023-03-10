<?php

declare(strict_types=1);

namespace Kernel\Exception;

class NotFoundException extends AbstractException
{
    public function __construct(string $message = '资源不存在', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
