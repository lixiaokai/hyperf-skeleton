<?php

declare(strict_types=1);

namespace Core\Service\Wechat;

use Core\Service\Wechat\Utils\WechatRequest;
use EasyWeChat\Factory as EasyWeChatFactory;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\OfficialAccount\Application as OfficialAccountApp;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Context\Context;
use Hyperf\Guzzle\CoroutineHandler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;

use function Hyperf\Collection\data_get;

/**
 * 微信 - 工厂类.
 *
 * 说明：使 EasyWeChat 支持协程
 *
 * @method static \EasyWeChat\Payment\Application         payment(array $config = [])
 * @method static \EasyWeChat\MiniProgram\Application     miniProgram(array $config = [])
 * @method static \EasyWeChat\OpenPlatform\Application    openPlatform(array $config = [])
 * @method static \EasyWeChat\OfficialAccount\Application officialAccount(array $config = [])
 * @method static \EasyWeChat\BasicService\Application    basicService(array $config = [])
 * @method static \EasyWeChat\Work\Application            work(array $config = [])
 * @method static \EasyWeChat\OpenWork\Application        openWork(array $config = [])
 * @method static \EasyWeChat\MicroMerchant\Application   microMerchant(array $config = [])
 */
class WechatFactory extends EasyWeChatFactory
{
    /**
     * @internal
     * @param string $name
     * @param array  $arguments
     */
    public static function __callStatic($name, $arguments = [])
    {
        $arguments = array_merge(data_get(config('easyWechat'), "{$name}.default"), $arguments);

        return self::creatCoroutineApp(parent::make($name, $arguments));
    }

    /**
     * 创建 - 协程化的应用服务容器.
     *
     * @see https://hyperf.wiki/3.0/#/zh-cn/sdks/wechat
     */
    protected static function creatCoroutineApp(ServiceContainer $app): ServiceContainer
    {
        $handler = new CoroutineHandler();
        $stack = HandlerStack::create($handler);

        // 1. 替换 Handler
        // 设置 HttpClient，部分接口直接使用了 http_client
        $config = $app->config->get('http', []);
        $config['handler'] = $stack;
        $app->rebind('http_client', new Client($config));
        // 部分接口在请求数据时，会根据 guzzle_handler 重置 Handler
        $app['guzzle_handler'] = $handler;
        // 如果使用的是 OfficialAccount，则还需要设置以下参数
        if ($app instanceof OfficialAccountApp) {
            $app->oauth->setGuzzleOptions([
                'http_errors' => false,
                'handler' => $stack,
            ]);
        }

        // 2. 替换缓存
        $app['cache'] = make(CacheInterface::class);

        // 3. 替换 Request
        if (Context::get(ServerRequestInterface::class)) {
            $app->rebind('request', new WechatRequest());
        }

        return $app;
    }
}
