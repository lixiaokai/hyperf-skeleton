<?php

namespace HyperfTest\Repository;

use Core\Constants\Platform;
use Core\Repository\MenuRepository;
use PHPUnit\Framework\TestCase;

class MenuRepositoryTest extends TestCase
{
    /**
     * @see MenuRepository::getTrees()
     */
    public function testGetTrees()
    {
        // 获取总后台菜单树
        $menus = make(MenuRepository::class)->getTrees(Platform::ADMIN);
        var_dump($menus);

        self::assertTrue(true);
    }

    /**
     * @see MenuRepository::getList()
     */
    public function testGetList()
    {
        // 获取总后台菜单
        $menus = make(MenuRepository::class)->getList(Platform::ADMIN);
        var_dump($menus->toArray());

        self::assertTrue(true);
    }
}
