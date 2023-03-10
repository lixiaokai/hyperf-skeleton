<?php

declare(strict_types=1);

/**
 * 开发者工具 - 配置.
 *
 * 说明：
 * 1. namespace 表示默认命名空间，生成的文件会根据命名空间对应路径来保存
 * 2. 也可以通过增加参数 -N 'App\Admin\Controller' 修改命名空间
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/devtool
 */
return [
    'generator' => [
        'amqp' => [
            'consumer' => [
                'namespace' => 'Core\\Amqp\\Consumer',
            ],
            'producer' => [
                'namespace' => 'Core\\Amqp\\Producer',
            ],
        ],
        'aspect' => [
            'namespace' => 'Core\\Aspect',
        ],
        'command' => [
            'namespace' => 'Core\\Command',
        ],
        'controller' => [
            'namespace' => 'App\\Admin\\Controller',
            'stub' => BASE_PATH . '/core/Devtool/Generator/stubs/controller.stub',
            // 'stub' => BASE_PATH . '/vendor/hyperf/devtool/src/Generator/stubs/controller.stub', // 默认模板
        ],
        'job' => [
            'namespace' => 'Core\\Job',
        ],
        'listener' => [
            'namespace' => 'Core\\Listener',
        ],
        'middleware' => [
            'namespace' => 'Core\\Middleware',
        ],
        'Process' => [
            'namespace' => 'Core\\Processes',
        ],
        /* @see \Hyperf\Devtool\Generator\ResourceCommand 默认配置中没有该 API 资源配置，以下是自己加上的 */
        'resource' => [
            'namespace' => 'App\\Admin\\Resource',
        ],
    ],
];
