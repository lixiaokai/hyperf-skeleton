<?php

declare(strict_types=1);

namespace App\Admin\Resource\Common;

use Core\Model\Attachment;
use Core\Resource\AbstractResource;

/**
 * 文件 - 详情 - 资源.
 *
 * @property Attachment $resource
 */
class FileResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'storageMode' => $this->resource->storageMode,
            'storageModeText' => $this->resource->storageModeText,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'size' => $this->resource->size,
            'path' => $this->resource->path,
            'pullPath' => $this->resource->fullPath,
            'hash' => $this->resource->hash,
            'createdAt' => $this->toDateTimeString($this->resource->createdAt),
            'updatedAt' => $this->toDateTimeString($this->resource->updatedAt),
            'deletedAt' => $this->toDateTimeString($this->resource->deletedAt),
        ];
    }
}
