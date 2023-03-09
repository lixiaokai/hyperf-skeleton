<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;
use Kernel\Constants\BaseConstants;

/**
 * 通用状态 - 常量.
 *
 * @method static string getText(string $code)
 */
#[Constants]
class Status extends BaseConstants
{
    /**
     * @Text("启用")
     */
    public const ENABLE = 'enable';

    /**
     * @Text("禁用")
     */
    public const DISABLE = 'disable';
}
