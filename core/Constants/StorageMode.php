<?php

declare(strict_types=1);

namespace Core\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * 文件上传存储方式 - 常量.
 *
 * @method static string getText(string $code)
 */
#[Constants]
class StorageMode extends AbstractConstants
{
    /**
     * @Text("本地")
     */
    public const LOCAL = 'local';

    /**
     * @Text("阿里云")
     */
    public const OSS = 'oss';

    /**
     * @Text("腾讯云")
     */
    public const COS = 'cos';

    /**
     * @Text("七牛云")
     */
    public const QINIU = 'qiniu';
}
