<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 用户类型 - 常量.
 *
 * @method static getText(string $code)
 */
#[Constants]
class UserType extends AbstractConstants
{
    /**
     * @Text("总后台用户")
     */
    public const ADMIN = 'admin';
}
