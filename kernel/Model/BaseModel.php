<?php

declare(strict_types=1);

namespace Kernel\Model;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Database\Model\Concerns\CamelCase;
use Hyperf\DbConnection\Model\Model;

abstract class BaseModel extends Model
{
    use CamelCase;

    /**
     * 获取 - [ 带库名 ] 带表名的字段.
     *
     * @see Model::qualifyColumn()     如果没有第 2 个参数，等同于该方法
     * @param  string|string[] $col    字段名
     * @param  bool            $withDb 是否带库名
     * @return string          返回字符串 ( 例如：user.id 或 dbName.user.id )
     */
    public static function column(array|string $col = '*', bool $withDb = false): string
    {
        $cols = (array) $col;
        $tbName = self::table($withDb);

        return collect($cols)->map(fn (string $col) => $tbName . '.' . $col)->implode(',');
    }

    /**
     * 获取 - [ 带库名 ] 的表名.
     *
     * @param bool $withDb 是否带库名
     */
    public static function table(bool $withDb = false): string
    {
        $self = make(static::class);
        $tbName = $self->getTable();
        if ($withDb) {
            $dbName = make(ConfigInterface::class)->get("databases.{$self->getConnectionName()}.database");
            $tbName = $dbName . '.' . $tbName;
        }

        return $tbName;
    }
}
