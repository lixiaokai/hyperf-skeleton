<?php

declare(strict_types=1);

/**
 * 监听器 - 配置文件.
 *
 * 说明：
 * 1. 自定义监听器注册通常使用注解的方式
 * 2. 这里一般使用的是内置的监听器，避免新建一个文件去继承原来的监听器，并在新建的文件上使用注解
 *
 * 顺序
 * 1. 这里配置的监听器触发顺序根据该配置文件的顺序
 * 2. 注解注册监听器通过设置注解属性 priority 属性定义当前监听器的顺序，数字越大优先级越高
 */
return [
    Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler::class,
    Hyperf\Command\Listener\FailToHandleListener::class,
];
