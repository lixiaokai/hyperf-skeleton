<?php

declare(strict_types=1);

namespace Kernel\Resource\Response;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;

/**
 * 自定义分页 - 响应类.
 */
class PaginatedResponse extends \Hyperf\Resource\Response\PaginatedResponse
{
    public function toResponse(): ResponseInterface
    {
        return $this->response()
            ->withStatus($this->calculateStatus())
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(Json::encode($this->wrap(
                array_merge_recursive(
                    $this->resource->resolve(),
                    $this->paginationInformation()
                ),
                array_merge_recursive(
                    $this->resource->with(),
                    $this->resource->additional
                )
            ))));
    }
}
