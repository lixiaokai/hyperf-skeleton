<?php

declare(strict_types=1);

namespace App\Admin\Controller\Common;

use App\Admin\Middleware\AuthMiddleware;
use App\Admin\Resource\Common\FileResource;
use Core\Controller\AbstractController;
use Core\Service\File\File;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use League\Flysystem\FilesystemException;
use Psr\Http\Message\ResponseInterface;

/**
 * 文件 - 控制器.
 */
#[Controller('admin/common/file')]
#[Middlewares([AuthMiddleware::class])]
class FileController extends AbstractController
{
    /**
     * 文件 - 上传.
     *
     * @throws FilesystemException
     */
    #[PostMapping('upload')]
    public function upload(): ResponseInterface
    {
        $uploadedFile = $this->request->file('upload');
        $res = File::upload($uploadedFile);

        return FileResource::make($res);
    }
}
