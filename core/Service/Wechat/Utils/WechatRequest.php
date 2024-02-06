<?php

declare(strict_types=1);

namespace Core\Service\Wechat\Utils;

use Hyperf\Context\ApplicationContext;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * 替换 EasyWeChat 的 Request.
 *
 * 说明：EasyWeChat 是为 PHP-FPM 架构设计的，所以在某些地方需要修改下才能在 Hyperf 下使用
 */
class WechatRequest extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);

        $files = [];
        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $cookie = $request->getCookieParams();
        $uploadFiles = $request->getUploadedFiles() ?? [];
        /** @var UploadedFile $v */
        foreach ($uploadFiles as $k => $v) {
            $files[$k] = $v->toArray();
        }
        $server = $request->getServerParams();
        $xml = $request->getBody()->getContents();

        parent::__construct($get, $post, [], $cookie, $files, $server, $xml);

        // headers 需要后赋值替换
        $this->headers = new HeaderBag($request->getHeaders());
    }
}
