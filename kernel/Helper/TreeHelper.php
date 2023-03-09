<?php

declare(strict_types=1);

namespace Kernel\Helper;

/**
 * 数组和树形数据转换 - 助手类.
 */
class TreeHelper
{
    /**
     * 引用算法返回层级树数组.
     *
     * 例子：
     * 要转换的数据：
     * $lists = [
     *   ['id' => 1, 'parentId' => 0, 'name' => '一级 1'],
     *   ['id' => 2, 'parentId' => 0, 'name' => '一级 2'],
     *   ['id' => 3, 'parentId' => 2, 'name' => '二级 3'],
     *   ['id' => 4, 'parentId' => 3, 'name' => '三级 4'],
     *   ['id' => 5, 'parentId' => 0, 'name' => '一级 5'],
     *   ['id' => 6, 'parentId' => 1, 'name' => '二级 6'],
     * ];
     * 转换后的数据 $trees = self::toTrees($lists)：
     * $trees = [
     *   ['id' => 1, 'parentId' => 0, 'name' => '一级 1', 'children' => [
     *     ['id' => 6, 'parentId' => 1, 'name' => '二级 6'],
     *   ]],
     *   ['id' => 2, 'parentId' => 0, 'name' => '一级 2', 'children' => [
     *     ['id' => 3, 'parentId' => 2, 'name' => '二级 3', 'children' => [
     *       ['id' => 4, 'parentId' => 3, 'name' => '三级 4'],
     *     ]],
     *   ]],
     *   ['id' => 5, 'parentId' => 0, 'name' => '一级 5'],
     * ];
     *
     * @param array  $lists         要转换的数据
     * @param string $idField       id 字段
     * @param string $pidField      父 id 字段
     * @param string $childrenField 子节点字段
     * @param bool   $indexKey      输出的数组是否包含索引 key 值
     * @param array  $rootVal       根节点值 ( 默认值为 0 和 null )
     */
    public static function toTrees(
        array $lists,
        string $idField = 'id',
        string $pidField = 'parentId',
        string $childrenField = 'children',
        bool $indexKey = false,
        array $rootVal = [0, null]
    ): array {
        $trees = [];

        // 如果 $lists 不是以 id 值作为健名，则重组以 id 值做为键名的数组
        if (isset($lists[0]) && ! empty($lists[0])) {
            $lists = array_column($lists, null, $idField);
        }

        foreach ($lists as $idVal => &$list) {
            $pidVal = $list[$pidField];
            if (in_array($pidVal, $rootVal, true)) { // 是否根节点
                $indexKey ? $trees[$idVal] = &$list : $trees[] = &$list;
            } elseif (isset($lists[$pidVal])) {
                $indexKey ? $lists[$pidVal][$childrenField][$idVal] = &$list : $lists[$pidVal][$childrenField][] = &$list;
            }
        }

        return $trees;
    }

    /**
     * 递归算法把上面 toTree() 生成的层级树转换为列表.
     *
     * 例子：
     * 查看上面 toTrees() 方法的例子，倒过来即可.
     *
     * @param array  $trees         原来的树
     * @param string $idField       id 字段
     * @param string $childrenField 子节点字段
     * @param bool   $addChildren   列表数组是否附加子节点
     * @param bool   $indexKey      输出的数组是否包含索引 key 值
     * @param int    $depthVal      节点深度值 ( 从 0 开始，可用于输出节点时缩进 )
     * @param array  &$list         过渡用的中间数组，
     */
    public static function toLists(
        array $trees,
        string $idField = 'id',
        string $childrenField = 'children',
        bool $addChildren = false,
        bool $indexKey = false,
        int $depthVal = 0,
        array &$list = []
    ): array {
        foreach ($trees as $tree) {
            $refer = $tree;
            $refer['depth'] = $depthVal;
            $idVal = $tree[$idField];
            if (isset($refer[$childrenField])) {
                if ($addChildren === false) {
                    unset($refer[$childrenField]);
                }
                $indexKey ? $list[$idVal] = $refer : $list[] = $refer;
                self::toLists($tree[$childrenField], $idField, $childrenField, $addChildren, $indexKey, $depthVal + 1, $list);
            } else {
                $indexKey ? $list[$idVal] = $refer : $list[] = $refer;
            }
        }

        return $list;
    }

    /**
     * 找父母 ( 迭代算法 ).
     *
     * 用途：面包屑导航.
     * 例子：
     * 要查找的数据：
     * $lists = [
     *   ['id' => 1, 'parentId' => 0, 'name' => '一级 1'],
     *   ['id' => 2, 'parentId' => 0, 'name' => '一级 2'],
     *   ['id' => 3, 'parentId' => 2, 'name' => '二级 3'],
     *   ['id' => 4, 'parentId' => 3, 'name' => '三级 4'],
     *   ['id' => 5, 'parentId' => 0, 'name' => '一级 5'],
     *   ['id' => 6, 'parentId' => 1, 'name' => '二级 6'],
     * ];
     * 查找后的数据 $parents = self::findParent($lists, 4)：
     * $parents = [
     *   2 => ['id' => 2, 'parentId' => 0, 'name' => '一级 2'],
     *   3 => ['id' => 3, 'parentId' => 2, 'name' => '二级 3'],
     *   4 => ['id' => 4, 'parentId' => 3, 'name' => '三级 4'],
     * ];
     *
     * @param  array  $lists    数据列表
     * @param  int    $idVal    要查找的 ID 值
     * @param  string $idField  id 字段名称
     * @param  string $pidField 父 ID 字段名称
     * @param  array  $rootVal  根节点值 ( 默认值为 0 和 null )
     * @return array  返回带索引的数组列表
     */
    public static function findParents(
        array $lists,
        int $idVal,
        string $idField = 'id',
        string $pidField = 'parentId',
        array $rootVal = [0, null]
    ): array {
        $list = [];

        if (empty($lists)) {
            return $list;
        }

        // 如果 $lists 不是以 id 值作为健名，则重组以 id 值做为键名的数组
        if (isset($lists[0]) && ! empty($lists[0])) {
            $lists = array_column($lists, null, $idField);
        }

        // 一层层向上查找，直到根节点
        $depth = 0;
        while (! in_array($idVal, $rootVal, true)) {
            $list[$idVal] = $lists[$idVal];
            $list[$idVal]['depth'] = ++$depth; // 附加深度

            $idVal = $lists[$idVal][$pidField];
        }

        return array_reverse($list, true);
    }
}
