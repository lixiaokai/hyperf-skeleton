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

    public string $iatString;

    public string $expString;

    public function __construct(array|object $parameters)
    {
        foreach ((array) $parameters as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }

        $this->init();
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
            'expString' => $this->expString,
            'iatString' => $this->iatString,
        ];
    }

    private function init(): void
    {
        $time = time();

        empty($this->iat) && $this->iat = $time;
        empty($this->exp) && $this->exp = $time - 86400 * 30; // 30 天

        $this->iatString = date('Y-m-d H:i:s', $this->iat);
        $this->expString = date('Y-m-d H:i:s', $this->exp);
    }
}
