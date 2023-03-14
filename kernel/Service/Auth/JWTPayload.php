<?php

declare(strict_types=1);

namespace Kernel\Service\Auth;

/**
 * JWT Payload 数据对象.
 */
class JWTPayload
{
    /**
     * @var string 签发者
     */
    public string $iss = 'auth';

    /**
     * @var string 主题
     */
    public string $sub = 'token';

    /**
     * @var int 签发时间
     */
    public int $iat;

    /**
     * @var int 过期时间
     */
    public int $exp;

    /**
     * @var int 携带数据
     */
    public int $uid;

    public function __construct(array|object $parameters)
    {
        $this->init(); // 初始化

        foreach ((array) $parameters as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
    }

    public static function make(...$parameters): self
    {
        return new static(...$parameters);
    }

    public function toArray(): array
    {
        return [
            'iss' => $this->iss,
            'sub' => $this->sub,
            'iat' => $this->iat,
            'exp' => $this->exp,
            'uid' => $this->uid,
        ];
    }

    public function getIatString(): string
    {
        return date('Y-m-d H:i:s', $this->iat);
    }

    public function getExpString(): string
    {
        return date('Y-m-d H:i:s', $this->exp);
    }

    public function setIat(int $timestamp): self
    {
        $this->iat = $timestamp;

        return $this;
    }

    public function setExp(int $daysExp = 14): self
    {
        $this->exp = time() + 86400 * $daysExp;

        return $this;
    }

    protected function init(): void
    {
        $timestamp = time();

        $this->setIat($timestamp);
        $this->setExp();
    }
}
