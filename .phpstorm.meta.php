<?php

namespace PHPSTORM_META {
    // Reflect
    use Core\Constants\ContextKey;

    override(\Psr\Container\ContainerInterface::get(0), map(['' => '@']));
    override(\Hyperf\Context\Context::get(), map([
        'user' => \Core\Model\User::class,
        ContextKey::USER => \Core\Model\User::class,

        'userAdmin' => \Core\Model\UserAdmin::class,
        ContextKey::USER_ADMIN => \Core\Model\UserAdmin::class,

        '' => '@'
    ]));
    override(\make(0), map(['' => '@']));
    override(\di(0), map(['' => '@']));
}
