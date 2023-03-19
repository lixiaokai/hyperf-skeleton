<?php

declare(strict_types=1);

namespace Core\Service\File;

use Core\Constants\ContextKey;
use Core\Model\Attachment;
use Hyperf\Context\Context;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Kernel\Exception\BusinessException;
use Kernel\Exception\NotFoundException;
use Kernel\Service\File\Upload;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;

/**
 * 文件上传类.
 */
class File
{
    /**
     * 上传.
     *
     * @throws FilesystemException
     */
    public static function upload(UploadedFile $uploadedFile): Attachment
    {
        if (! $uploadedFile->isValid()) {
            throw new BusinessException('上传失败: ' . $uploadedFile->getError());
        }

        $attachmentService = make(AttachmentService::class);
        $upload = make(Upload::class);

        try {
            // 1. 根据 md5 获取 [ 附件记录 ]
            $hash = md5_file($uploadedFile->getRealPath());
            $attachment = $attachmentService->getByHash($hash);

            // [ 附件记录 ] 存在，但 [ 附件文件 ] 不存在则上传 + 更新记录
            if (make(Filesystem::class)->fileExists($attachment->path)) {
                $path = $upload->handle($uploadedFile);
                $attachment = $attachmentService->update($attachment, self::buildData($uploadedFile, $path, $hash));
            }
        } catch (NotFoundException) {
            // [ 附件记录 ] 不存在 ( 表示：附件文件无法确定是否存在 ) 则上传 + 创建记录
            $path = $upload->handle($uploadedFile);
            $attachment = $attachmentService->create(self::buildData($uploadedFile, $path, $hash));
        }

        return $attachment;
    }

    /**
     * 附件 - 组装数据.
     */
    protected static function buildData(UploadedFile $uploadedFile, string $path, string $hash): array
    {
        return [
            'userId' => Context::get(ContextKey::UID),
            'storageMode' => config('file.default'),
            'name' => $uploadedFile->getClientFilename(),
            'type' => $uploadedFile->getClientMediaType(),
            'size' => $uploadedFile->getSize(),
            'path' => $path,
            'hash' => $hash,
        ];
    }
}
