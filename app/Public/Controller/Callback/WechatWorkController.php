<?php

declare(strict_types=1);

namespace App\Public\Controller\Callback;

use Core\Controller\AbstractController;
use Core\Service\Wechat\Utils\WechatResponse;
use Core\Service\Wechat\WechatFactory;
use Core\Service\Wechat\WechatWorkService;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * 企业微信接口回调 - 控制器.
 */
#[Controller('public/callback/wechat-work')]
class WechatWorkController extends AbstractController
{
    #[Inject]
    protected WechatWorkService $service;

    /**
     * 审批 - 首次配置 URL 时验证 URL 有效性.
     *
     * 说明：
     * 应用管理 -> 审批 -> API -> 接收事件服务器 -> 设置
     *
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    #[GetMapping('approval')]
    public function callback(): ResponseInterface
    {
        $res = $this->service->serverValidate();

        return WechatResponse::Response($res);
    }

    /**
     * 审批 - 接口回调.
     *
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws ReflectionException
     */
    #[PostMapping('approval')]
    public function approval(): ResponseInterface
    {
        $app = WechatFactory::work();
        $app->server->push(function ($message) {
            var_dump($message);
        });
        $res = $app->server->serve();

        return WechatResponse::Response($res);
    }
}
