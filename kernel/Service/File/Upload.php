<?php

declare(strict_types=1);

namespace Kernel\Service\File;

use Carbon\Carbon;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Kernel\Exception\BusinessException;
use Kernel\Service\AbstractService;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;

/**
 * 上传 - 服务类.
 */
class Upload extends AbstractService
{
    #[Inject]
    protected Filesystem $filesystem;

    protected UploadedFile $uploadedFile;

    /**
     * 上传处理.
     *
     * @return string 上传后的相对路径
     */
    public function handle(UploadedFile $uploadedFile): string
    {
        $this->init($uploadedFile);

        // 文件存储路径
        $fullSaveName = $this->getFullSaveName();

        try {
            $this->filesystem->writeStream($fullSaveName, $this->uploadedFile->getStream()->detach());
        } catch (FilesystemException $e) {
            $this->logger->error($e->getMessage());
            throw new BusinessException('文件上传异常，请重试操作');
        }

        return $fullSaveName;
    }

    /**
     * 初始化.
     */
    protected function init(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * 获取 - 完整存储文件名 ( 带路径 ).
     */
    protected function getFullSaveName(): string
    {
        return $this->getSavePath() . '/' . $this->getSaveName();
    }

    /**
     * 获取 - 保存路径.
     */
    protected function getSavePath(): string
    {
        return Carbon::now()->format('ym');
    }

    /**
     * 获取 - 保存的文件名.
     */
    protected function getSaveName(): string
    {
        return Carbon::now()->format('Hisu') . '.' . strtolower($this->uploadedFile->getExtension());
    }
}
