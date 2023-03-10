<?php

declare(strict_types=1);

namespace Kernel\Response;

use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;

/**
 * 响应类.
 *
 * @see \Hyperf\HttpServer\Response 参考
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

    /**
     * 输出空数据.
     */
    public static function withEmpty(): ResponseInterface
    {
        return (new self())->toJson();
    }

    /**
     * 输出数据.
     */
    public static function withData(mixed $data = [], string $message = '操作成功'): ResponseInterface
    {
        return (new self($data, $message))->toJson();
    }

    /**
     * 执行成功.
     */
    public static function success(string $message = '操作成功'): ResponseInterface
    {
        return (new self([], $message))->toJson();
    }

    protected function toJson(): ResponseInterface
    {
        return $this->response()
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
