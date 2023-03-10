<?php

declare(strict_types=1);

namespace App\Demo\Collection;

use Core\Model\Test;

/**
 * 测试 - 列表 - 资源.
 *
 * @property Test $resource
 */
class TestResource extends \App\Demo\Resource\TestResource
{
    // 由于 [ 列表 ] 和 [ 详情 ] API 一样，这里直接读取 [ 详情 ] 资源
}
