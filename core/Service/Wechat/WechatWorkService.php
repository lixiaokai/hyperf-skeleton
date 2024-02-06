<?php

declare(strict_types=1);

namespace Core\Service\Wechat;

use Core\Service\AbstractService;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Config\Annotation\Value;
use Symfony\Component\HttpFoundation\Response;

/**
 * 企业微信 - 服务类.
 */
class WechatWorkService extends AbstractService
{
    /**
     * 注解获取配置.
     *
     * @see config/autoload/easyWechat.php
     * @Value('easyWechat')
     */
    protected array $config;

    /**
     * 企业微信 - 首次配置 URL 时验证 URL 有效性.
     *
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function serverValidate(): Response
    {
        $app = WechatFactory::work();

        return $app->server->serve();
    }

    public function test()
    {
        $app = WechatFactory::work();

        $users = $app->user->getMemberAuthList();
        var_dump($users);


        return $app->server->serve();
    }
}
