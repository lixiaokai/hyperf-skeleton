<?php

declare(strict_types=1);

namespace Kernel\Exception;

class DataSaveException extends BaseException
{
    public function __construct(string $message = '数据保存异常', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
