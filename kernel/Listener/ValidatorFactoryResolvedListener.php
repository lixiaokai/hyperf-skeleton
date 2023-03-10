<?php

declare(strict_types=1);

namespace Kernel\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * 自定义验证规则 - 监听器.
 */
#[Listener]
class ValidatorFactoryResolvedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    /**
     * @param object&ValidatorFactoryResolved $event
     */
    public function process(object $event): void
    {
        $this->registerPrice($event->validatorFactory);
        $this->registerMobile($event->validatorFactory);
    }

    /**
     * 注册 price 验证器.
     */
    protected function registerPrice(ValidatorFactoryInterface $validatorFactory): void
    {
        $validatorFactory->extend('price', function ($attribute, $value, $parameters, $validator) {
            return (bool) preg_match('/^\d+(?:\.\d{1,2})?$/', (string) $value);
        });
        $validatorFactory->replacer('price', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });
    }

    /**
     * 注册 mobile 验证器.
     */
    protected function registerMobile(ValidatorFactoryInterface $validatorFactory): void
    {
        $validatorFactory->extend('mobile', function ($attribute, $value, $parameters, $validator) {
            return (bool) preg_match('/^1\d{10}$/', (string) $value);
        });
        $validatorFactory->replacer('mobile', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });
    }
}
