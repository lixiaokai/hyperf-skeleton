<?php

declare(strict_types=1);

namespace Core\Model\Traits;

use Core\Constants\Status;
use Hyperf\Database\Model\Builder;
use Hyperf\Utils\Collection;

/**
 * 通用状态 - 模型.
 *
 * @property string $status 状态 ( enable-启用 disable-禁用 )
 *
 * @property Collection $statusKeyValue 状态 - keyValue
 * @property string     $statusText     状态 - 文字
 *
 * @method static Builder enable()  查询 [ 已启用 ] 作用域
 * @method static Builder disable() 查询 [ 已禁用 ] 作用域
 */
trait StatusTrait
{
    public function getStatusTextAttribute(): string
    {
        return Status::getText($this->status);
    }

    public function getStatusKeyValueAttribute(): Collection
    {
        return collect(Status::dict('Text'))->map(fn (array $item) => [
            'key' => $item['key'],
            'value' => $item['value'],
            'isSelect' => $item['key'] === $this->status,
        ]);
    }

    /**
     * 只包含 [ 已启用 ] 的查询作用域.
     */
    public function scopeEnable(Builder $query): Builder
    {
        return $query->where(self::column('status'), Status::ENABLE);
    }

    /**
     * 只包含 [ 已禁用 ] 的查询作用域.
     */
    public function scopeDisable(Builder $query): Builder
    {
        return $query->where(self::column('status'), Status::DISABLE);
    }

    /**
     * 是否启用.
     */
    public function isEnable(): bool
    {
        return $this->status === Status::ENABLE;
    }

    /**
     * 是否禁用.
     */
    public function isDisable(): bool
    {
        return $this->status === Status::DISABLE;
    }
}
