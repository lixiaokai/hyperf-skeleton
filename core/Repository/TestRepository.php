<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Constants\Status;
use Core\Model\Test;
use Hyperf\Database\Model\Model;

/**
 * 测试 - 仓库类.
 *
 * @method Test getById(int $id)
 * @method Test create(array $data)
 * @method Test update(Test $model, array $data)
 */
class TestRepository extends AbstractRepository
{
    protected Model|string $modelClass = Test::class;

    /**
     * 启用.
     */
    public function enable(Test $test): Test
    {
        $test->status = Status::ENABLE;
        $test->save();

        return $test;
    }

    /**
     * 禁用.
     */
    public function disable(Test $test): Test
    {
        $test->status = Status::DISABLE;
        $test->save();

        return $test;
    }
}
