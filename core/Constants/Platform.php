<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 终端平台 - 常量.
 *
 * @method static string getText(string $code)
 * @deprecated 待废弃删除
 */
#[Constants]
class Platform extends AbstractConstants
{
    /**
     * @Text("总后台")
     */
    public const ADMIN = 'admin';
}
