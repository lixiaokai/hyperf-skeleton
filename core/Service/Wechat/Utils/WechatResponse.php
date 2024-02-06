<?php

declare(strict_types=1);

namespace Core\Service\Wechat\Utils;

use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * 响应 - 帮助类.
 *
 * Todo: 待重新封装.
 */
class WechatResponse
{
    public static function Response(Response $response): PsrResponseInterface
    {
        $psrResponse = Context::get(PsrResponseInterface::class);
        $psrResponse = $psrResponse->withBody(new SwooleStream($response->getContent()))->withStatus($response->getStatusCode());
        foreach ($response->headers->all() as $key => $item) {
            $psrResponse = $psrResponse->withHeader($key, $item);
        }
        return $psrResponse;
    }
}
