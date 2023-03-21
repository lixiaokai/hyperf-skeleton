<?php
declare(strict_types=1);

namespace Core\Service\Sms\Template;

use Overtrue\EasySms\Contracts\GatewayInterface;
use Overtrue\EasySms\Message;

/**
 * 验证码 - 短信消息.
 */
class CaptchaMessage extends Message
{
    /**
     * 发送网关.
     *
     * 覆盖全局配置中的 default.gateways
     *
     * @see config/autoload/easySms.php
     * @var string[]
     */
    protected $gateways = ['aliyun'];

    /**
     * 验证码.
     */
    protected string $code;

    public function __construct(string $code)
    {
        parent::__construct();

        $this->code = $code;
    }

    /**
     * 发送内容.
     *
     * 说明：
     * 1. [ 螺丝帽 ] 只需要定义 content 即可.
     * 2. [ 阿里云短信 ] 不用定义，仅作为模板演示
     */
    public function getContent(GatewayInterface $gateway = null): string
    {
        // 模板名称：验证码短信
        // 模板 CODE：'SMS_225170023'
        // 模板详情：'您的验证码为：${code}，请勿泄露于他人！'

        return '您的验证码为：${code}，请勿泄露于他人！';
    }

    /**
     * 模板 ID.
     *
     * 比如：
     * 1. 阿里云需要定义 template + data.
     */
    public function getTemplate(GatewayInterface $gateway = null): string
    {
        return 'SMS_247520204';
    }

    /**
     * 模板参数.
     *
     * 比如：阿里云需要定义 template + data.
     */
    public function getData(GatewayInterface $gateway = null): array
    {
        return ['code' => $this->code];
    }
}
