<?php

declare(strict_types=1);

namespace Kernel\Response;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;

/**
 * 响应类.
 */
class Response
{
    protected mixed $data;

    protected string $message = '';

    public function __construct(mixed $data = [], string $message = '')
    {
        $this->data = $data;
        $this->message = $message;
    }

    public static function withEmpty(): ResponseInterface
    {
        return (new self())->toJson();
    }

    public static function withData(mixed $data = []): ResponseInterface
    {
        return (new self($data))->toJson();
    }

    public static function success(mixed $data = [], string $message = '操作成功'): ResponseInterface
    {
        return (new self($data, $message))->toJson();
    }

    protected function toJson(): ResponseInterface
    {
        return $this->response()
            ->withStatus(200)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(Json::encode([
                'code' => 200,
                'message' => $this->message,
                'data' => $this->data,
            ])));
    }

    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
}
