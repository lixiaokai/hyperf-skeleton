<?php

declare(strict_types=1);

/**
 * 单租户配置.
 *
 * 应用和租户映射配置
 */
use Core\Constants\AppId;

return [
    // 总后台为单租户模式，锁死租户
    AppId::ADMIN => [
        'id' => 1, // 租户 ID
    ],
];
