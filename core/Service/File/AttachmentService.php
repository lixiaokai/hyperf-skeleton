<?php

namespace Core\Service\File;

use Core\Model\Attachment;
use Core\Repository\AttachmentRepository;
use Core\Service\AbstractService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\BusinessException;
use Kernel\Exception\NotFoundException;

/**
 * 附件 - 服务类.
 */
class AttachmentService extends AbstractService
{
    #[Inject]
    protected AttachmentRepository $repo;

    /**
     * 附件 - 列表 ( 含筛选 ).
     */
    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery()->orderBy('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 附件 - 详情.
     */
    public function getById(int $id): Attachment
    {
        try {
            $attachment = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new BusinessException('该附件不存在');
        }

        return $attachment;
    }

    /**
     * 附件 - 详情.
     */
    public function getByHash(string $hash, array $columns = ['*']): Attachment
    {
        return $this->repo->getByHash($hash, $columns);
    }

    /**
     * 附件 - 创建.
     */
    public function create(array $data): Attachment
    {
        return $this->repo->create($data);
    }

    /**
     * 附件 - 修改.
     */
    public function update(Attachment $attachment, array $data): Attachment
    {
        return $this->repo->update($attachment, $data);
    }

    /**
     * 附件 - 删除.
     */
    public function delete(Attachment $attachment): bool
    {
        return $this->repo->delete($attachment);
    }
}
