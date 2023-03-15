<?php

declare(strict_types=1);

namespace Kernel\Repository;

use Exception;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\ModelNotFoundException;
use Kernel\Exception\BusinessException;
use Kernel\Exception\DataSaveException;
use Kernel\Exception\NotFoundException;
use Kernel\Repository\Traits\Searchable;

/**
 * 仓库 - 抽象基类.
 */
abstract class AbstractRepository
{
    use Searchable;

    /**
     * 模型 class.
     *
     * 属性类型 Model 仅作为 IDE 提醒
     */
    protected Model|string $modelClass;

    public function __construct(protected StdoutLoggerInterface $logger)
    {
        if (! $this->modelClass || ! class_exists($this->modelClass) && ! interface_exists($this->modelClass)) {
            throw new BusinessException('$modelClass 配置错误');
        }
    }

    public function getQuery(): Builder
    {
        return $this->modelClass::query();
    }

    public function getById(int $id, array $columns = ['*']): Model
    {
        try {
            return $this->modelClass::findOrFail($id, $columns);
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        }
    }

    public function getByIds(array $ids, array $columns = ['*']): Collection
    {
        return $this->modelClass::findMany($ids, $columns);
    }

    public function create(array $data): Model
    {
        try {
            return $this->modelClass::create($data);
        } catch (Exception $e) {
            throw new DataSaveException(message: '数据保存异常', previous: $e);
        }
    }

    public function update(Model $model, array $data): Model
    {
        try {
            $model->update($data);
        } catch (Exception $e) {
            throw new DataSaveException(message: '数据更新异常', previous: $e);
        }

        return $model;
    }

    public function delete(Model $model): bool
    {
        try {
            return $model->delete();
        } catch (Exception $e) {
            throw new DataSaveException(message: '数据删除异常', previous: $e);
        }
    }
}
