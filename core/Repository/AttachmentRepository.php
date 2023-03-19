<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Model\Attachment;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\ModelNotFoundException;
use Kernel\Exception\NotFoundException;

/**
 * 附件 - 仓库类.
 *
 * @method Attachment getById(int $id)
 * @method Attachment create(array $data)
 * @method Attachment update(Attachment $model, array $data)
 */
class AttachmentRepository extends AbstractRepository
{
    protected string|Model $modelClass = Attachment::class;

    public function getByHash(string $hash, array $columns = ['*']): Attachment|Model
    {
        try {
            return $this->modelClass::where('hash', $hash)->firstOrFail($columns);
        } catch (ModelNotFoundException) {
            throw new NotFoundException('附件信息不存在');
        }
    }
}
