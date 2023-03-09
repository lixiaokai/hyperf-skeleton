<?php

declare(strict_types=1);

namespace Kernel\Helper;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * 工具 - 助手类.
 */
class UtilsHelper
{
    /**
     * 获取 - 真实 IP 地址.
     */
    public static function realIp(): string
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);

        // 一层一层获取，直到有值为止
        $ip = $request->header('x-real-ip');
        if (empty($ip)) {
            $ip = $request->header('x-forwarded-for');
        }
        if (empty($ip)) {
            $ip = $request->server('http_client_ip');
        }
        if (empty($ip)) {
            $ip = $request->server('http_x_real_ip');
        }
        if (empty($ip)) {
            // 部分 CDN 会获取多层代理 IP，所以转成数组取第一个值
            $ip = explode(',', $request->server('http_x_forwarded_for', ''))[0];
        }
        if (empty($ip)) {
            $ip = $request->server('remote_addr');
        }

        return $ip;
    }
}
