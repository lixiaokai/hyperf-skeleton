<?php

declare(strict_types=1);

namespace Kernel\Request;

/**
 * 通用表单 - 抽象请求类.
 */
abstract class AbstractFormRequest extends \Hyperf\Validation\Request\FormRequest
{
    /**
     * 需要过滤的空字符串字段.
     */
    protected array $filterEmptyStringField = [];

    /**
     * 判断用户是否有请求权限.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 再次过滤空字符串字段.
     */

    /**
     * 获取 - 通过验证的数据.
     *
     * 说明：再次过滤空字符串字段
     *
     * @param string|null $scene
     */
    public function validated(string $scene = null): array
    {
        $scene && $this->scene($scene);

        return array_filter(parent::validated(), function ($value, $key) {
            return ! in_array($key, $this->filterEmptyStringField) || $value !== '';
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * 验证规则.
     */
    public function rules(): array
    {
        return [];
    }
}
