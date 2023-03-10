<?php

namespace App\Demo\Request;

use Core\Constants\Status;
use Core\Request\FormRequest;
use Hyperf\Validation\Rule;

/**
 * 测试 - 创建|修改 - 请求类.
 */
class TestRequest extends FormRequest
{
    public const SCENE_UPDATE = 'update';

    protected array $scenes = [
        // 修改时需要验证且提交的字段
        self::SCENE_UPDATE => ['password'],
    ];

    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:20'],
            'phone' => ['bail', 'required', 'mobile'],
            'password' => ['bail', 'required', 'max:32'],
            'status' => ['bail', 'required', Rule::in(Status::codes())],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '用户名',
            'phone' => '手机号',
            'password' => '密码',
            'status' => '状态',
        ];
    }
}
