<?php

declare(strict_types=1);

/**
 * 公共 - 提示类语言文件.
 *
 * 使用方法：https://hyperf.wiki/3.0/#/zh-cn/translation
 *
 * 统一风格：使用时使用全局函数 __() 翻译.
 * 比如：
 * 1. echo __('messages.success');
 * 2. echo __('messages.not.found', ['name' => '资源']);
 */
return [
    // 操作相关
    'success' => '操作成功',

    // 通用
    'not.found' => ':name 不存在',
];
