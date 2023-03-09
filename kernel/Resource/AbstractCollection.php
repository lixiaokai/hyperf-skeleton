<?php

declare(strict_types=1);

namespace Kernel\Resource;

use Hyperf\Resource\Json\ResourceCollection;
use Kernel\Resource\Response\PaginatedResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * API 集合 - 抽象基类.
 */
abstract class AbstractCollection extends ResourceCollection
{
    /**
     * 附加元数据.
     */
    public array $additional = [
        'code' => 200,
        'message' => '',
    ];

    /**
     * 附加顶层元数据.
     */
    public array $addToWith = [];

    public function __construct($resource)
    {
        parent::__construct($resource);

        // 附加顶层元数据
        foreach ($this->addToWith as $item) {
            $item && method_exists($this, $item) && $this->with[$item] = $this->{$item}();
        }
    }

    public function toArray(): array
    {
        return [
            'items' => $this->collection,
        ];
    }

    /**
     * 转为 - 响应.
     *
     * 说明：
     * 1. new Kernel\Resource\Response\PaginatedResponse\PaginatedResponse() 使用了自定义分页响应类
     * 2. 代码看起来和父类一样，实际命名空间不一样了
     */
    public function toResponse(): ResponseInterface
    {
        if ($this->isPaginatorResource($this->resource)) {
            return (new PaginatedResponse($this))->toResponse();
        }

        return parent::toResponse();
    }
}
