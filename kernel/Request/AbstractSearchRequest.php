<?php

declare(strict_types=1);

namespace Kernel\Request;

/**
 * 通用搜索 - 请求类.
 *
 * 注意：不要在该类写 rule 验证规则，避免继承的子类也生效，应该写到继承的子类中
 */
abstract class AbstractSearchRequest extends AbstractFormRequest
{
    public function searchParams(): array
    {
        return $this->all();
    }
}
