<?php

declare(strict_types=1);

namespace Kernel\Service\Auth;

use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ServerRequestInterface;

/**
 * JWT - 工具类.
 */
class JWTUtil
{
    /**
     * 获取 - 客户端请求 token.
     */
    public static function getRequestToken(): string
    {
        $request = ApplicationContext::getContainer()->get(ServerRequestInterface::class);

        return trim(str_ireplace('bearer', '', $request->getHeaderLine('authorization')));
    }
}
