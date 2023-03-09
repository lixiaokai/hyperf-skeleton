<?php

declare(strict_types=1);

/**
 * 热更新 - 配置文件.
 *
 * 不足：
 * 1. 删除文件和修改 .env 需要手动重启才能生效
 * 2. vendor 中的文件需要使用 classmap 形式自动加载才能被扫描 ( 即执行 composer dump-autoload -o )
 */
use Hyperf\Watcher\Driver\ScanFileDriver;

return [
    'driver' => ScanFileDriver::class,
    'bin' => 'php',
    'watch' => [
        'dir' => ['app', 'config', 'core', 'kernel', 'vendor'],
        'file' => ['.env'],
        'scan_interval' => 2000,
    ],
];
