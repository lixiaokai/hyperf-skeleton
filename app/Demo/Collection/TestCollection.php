<?php

declare(strict_types=1);

namespace App\Demo\Collection;

use Core\Resource\AbstractCollection;

/**
 * 基础用户 - 列表 - 集合.
 */
class TestCollection extends AbstractCollection
{
    public ?string $collects = TestResource::class;
}
