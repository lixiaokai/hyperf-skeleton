<?php

declare(strict_types=1);

namespace Core\Request;

use Kernel\Request\AbstractFormRequest;

/**
 * 通用表单 - 请求类.
 */
class FormRequest extends AbstractFormRequest
{
    /**
     * 常用 - 验证规则.
     *
     * ```
     * bail     首次失败后停止后面规则的检查 ( 必须是首规则 )
     * integer  大于 0 整形或字符串整形
     * numeric  数值
     *
     * in:enable,disable           存在给定的列表中
     * Rule::in(Status::codes())   如上
     *
     * exists:menu,id     存在于数据表
     * exists:db.menu,id  指定数据库
     * Rule::exists('menu', 'id')->where('status', Status::ENABLE)->whereNull('deleted_at')
     * ```
     */
    public function rules(): array
    {
        return [];
    }
}
