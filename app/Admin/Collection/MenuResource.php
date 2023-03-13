<?php

declare(strict_types=1);

namespace App\Admin\Collection;

use Core\Model\Menu;

/**
 * 菜单 - 列表 - 资源.
 *
 * @deprecated 没用到待废弃
 * @property Menu $resource
 */
class MenuResource extends \App\Admin\Resource\MenuResource
{
    // 由于 [ 列表 ] 和 [ 详情 ] API 一样，这里直接读取 [ 详情 ] 资源
}
