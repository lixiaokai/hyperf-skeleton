<?php

declare(strict_types=1);

namespace Core\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 登录限制 - 注解.
 *
 * @example
 * ```
 * #[LoginLimit(id: 'phone', prefix: 'admin')]
 * ```
 */
#[Attribute(Attribute::TARGET_METHOD)]
class LoginLimit extends AbstractAnnotation
{
    /**
     * @var string 必填唯一标识 ( 例如：输入的手机号、邮箱、账号等 )
     */
    public string $id;

    /**
     * @var int 监控秒数 ( 多少秒内 )
     */
    public int $watchSeconds = 60;

    /**
     * @var int 锁定秒数 ( 默认 600 秒 )
     */
    public int $lockSeconds = 600;

    /**
     * @var int 最大尝试次数
     */
    public int $maxAttempts = 5;

    /**
     * @var string 前缀 Key ( 默认为空字符串 )
     */
    public string $prefix = '';
}
