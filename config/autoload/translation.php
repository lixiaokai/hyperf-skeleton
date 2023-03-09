<?php

declare(strict_types=1);

/**
 * 多语言 - 配置.
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/translation
 */
return [
    'locale' => 'zh_CN',                         // 默认语言
    'fallback_locale' => 'en',                   // 备用语言
    'path' => BASE_PATH . '/storage/languages',  // 语言文件存放的文件夹
];
