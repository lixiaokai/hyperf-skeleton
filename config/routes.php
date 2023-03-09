<?php

declare(strict_types=1);

/**
 * 路由 - 配置文件.
 *
 * 说明：使用注解的方式注册路由，该配置忽略即可.
 * @see https://hyperf.wiki/3.0/#/zh-cn/router
 */
use Hyperf\HttpServer\Router\Router;

// 网站图标
Router::get('/favicon.ico', fn () => '');
// 健康检查
Router::get('/health', fn () => ['code' => 200, 'message' => 'ok']);
