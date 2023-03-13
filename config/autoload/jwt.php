<?php

declare(strict_types=1);

/**
 * JWT 配置.
 *
 * @see https://github.com/firebase/php-jwt 官网
 */
return [
    'key' => env('JWT_KEY'), // 加密 Key ( 32 位字符串 )
];
