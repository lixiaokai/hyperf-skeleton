<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;
use Kernel\Constants\BaseConstants;

/**
 * 终端平台 - 常量.
 *
 * @method static string getText(string $code)
 */
#[Constants]
class Platform extends BaseConstants
{
    /**
     * @Text("总后台")
     */
    public const ADMIN = 'admin';
}
