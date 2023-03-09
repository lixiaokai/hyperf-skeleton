<?php

declare(strict_types=1);

namespace Kernel\Repository;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\ModelNotFoundException;
use Kernel\Exception\BusinessException;
use Kernel\Exception\DataSaveException;
use Kernel\Exception\NotFoundException;

/**
 * 仓库 - 抽象基类.
 */
abstract class BaseRepository
{
    use Searchable;

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
        } catch (ModelNotFoundException $e) {
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
        } catch (\Exception $e) {
            $this->log($e);
            throw new DataSaveException('数据保存异常');
        }
    }

    public function update(Model $model, array $data): Model
    {
        try {
            $model->update($data);
        } catch (\Exception $e) {
            $this->log($e);
            throw new DataSaveException('数据更新异常');
        }

        return $model;
    }

    public function delete(Model $model): bool
    {
        try {
            return $model->delete();
        } catch (\Exception $e) {
            $this->log($e);
            throw new DataSaveException('数据删除异常');
        }
    }

    private function log(\Exception $e): void
    {
        $this->logger->error(sprintf('%s[%s] in %s', $e->getMessage(), $e->getLine(), $e->getFile()));
        $this->logger->error($e->getTraceAsString());
    }
}
