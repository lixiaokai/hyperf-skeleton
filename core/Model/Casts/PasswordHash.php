<?php

namespace Core\Model\Casts;

use Hyperf\Contract\CastsAttributes;

/**
 * 密码哈希 - 类型转换.
 */
class PasswordHash implements CastsAttributes
{
    /**
     * 参数.
     *
     * @see https://hyperf.wiki/3.0/#/zh-cn/db/mutators?id=%e7%b1%bb%e5%9e%8b%e8%bd%ac%e6%8d%a2%e5%8f%82%e6%95%b0 文档
     * @example model 中 ( 传入类型转换参数需使用 : 将参数与类名分隔，多个参数之间使用逗号分隔 )
     * ```
     * protected $casts = [
     *     'password' => PasswordHash::class . ':' . PASSWORD_ARGON2I,
     * ];
     * ```
     *
     * @param string $algorithm 算法
     */
    public function __construct(protected string $algorithm = PASSWORD_DEFAULT)
    {
    }

    public function get($model, string $key, $value, array $attributes): ?string
    {
        return $value;
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        return $value ? password_hash($value, $this->algorithm) : null;
    }
}
