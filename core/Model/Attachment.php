<?php

declare(strict_types=1);

namespace Core\Model;

use Carbon\Carbon;
use Core\Constants\StorageMode;
use Hyperf\Database\Model\SoftDeletes;
use Kernel\Helper\FormatHelper;
use League\Flysystem\Filesystem;

/**
 * 附件 - 模型.
 *
 * @property int     $id          附件 ID
 * @property int     $userId      用户 ID
 * @property string  $storageMode 存储方式 ( local-本地 oss-阿里云 cos-腾讯云 qiniu-七牛云 )
 * @property string  $name        原附件名
 * @property string  $type        附件类型
 * @property int     $size        附件大小 ( 字节 )
 * @property string  $path        附件路径
 * @property string  $hash        MD5 散列值
 * @property Carbon  $createdAt   创建时间
 * @property Carbon  $updatedAt   修改时间
 * @property ?Carbon $deletedAt   删除时间 ( 软删除 )
 *
 * @property string $fullPath        完整路径
 * @property string $storageModeText 存储方式 - 文字
 * @property string $sizeText        附件大小 - 文字 ( 更好可读性 )
 */
class Attachment extends AbstractModel
{
    use SoftDeletes;

    protected ?string $table = 'attachment';

    protected array $fillable = [
        'id',
        'user_id',
        'storage_mode',
        'name',
        'type',
        'size',
        'path',
        'hash',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getFullPathAttribute(): string
    {
        return make(Filesystem::class)->publicUrl($this->path);
    }

    public function getStorageModeTextAttribute(): string
    {
        return StorageMode::getText($this->storageMode);
    }

    public function getSizeTextAttribute(): string
    {
        return FormatHelper::bytesToString($this->size);
    }
}
