<?php

declare(strict_types=1);

/**
 * DI 的依赖关系和类对应关系 - 配置.
 *
 * @see https://hyperf.wiki/3.0/#/zh-cn/di?id=%E6%8A%BD%E8%B1%A1%E5%AF%B9%E8%B1%A1%E6%B3%A8%E5%85%A5
 */
return [
    // @see https://hyperf.wiki/3.0/#/zh-cn/db/gen
    Hyperf\Database\Commands\Ast\ModelUpdateVisitor::class => Kernel\Model\Visitor\ModelUpdateVisitor::class,
];
