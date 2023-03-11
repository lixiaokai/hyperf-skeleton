<?php

declare(strict_types=1);

namespace App\Admin\Collection;

use Core\Resource\AbstractCollection;

/**
 * 菜单 - 列表 - 集合.
 */
class MenuCollection extends AbstractCollection
{
    public ?string $collects = MenuResource::class;
}
