<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 应用 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class AppId extends AbstractConstants
{
    /**
     * @Text("总后台应用")
     */
    public const ADMIN = 'admin';
}
