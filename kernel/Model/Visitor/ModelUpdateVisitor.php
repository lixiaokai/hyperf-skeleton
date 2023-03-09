<?php

namespace Kernel\Model\Visitor;

use Hyperf\Utils\Str;

/**
 * gen:model 时转化相关类型为其他类型.
 *
 * 例如：默认会将 decimal 转化成为 float，在这里重写即可转成想要的 decimal:2
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/db/gen
 */
class ModelUpdateVisitor extends \Hyperf\Database\Commands\Ast\ModelUpdateVisitor
{
    protected function formatDatabaseType(string $type): ?string
    {
        $newType = parent::formatDatabaseType($type);

        // 默认会将 decimal 转化成为 float，这里重写为 decimal:2
        if (is_null($newType) && $type === 'decimal') {
            $newType = 'decimal:2';
        }

        return $newType;
    }

    protected function formatPropertyType(string $type, ?string $cast): ?string
    {
        $cast = parent::formatPropertyType($type, $cast);

        // 如果 cast 为 decimal，则 @property 改为 string
        if (Str::startsWith($cast, 'decimal')) {
            return 'string';
        }

        return $cast;
    }
}
