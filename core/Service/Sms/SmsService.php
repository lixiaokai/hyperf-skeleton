<?php

namespace Core\Service\Sms;

use Core\Exception\BusinessException;
use Core\Service\AbstractService;
use Hyperf\Config\Annotation\Value;
use Overtrue\EasySms\Contracts\MessageInterface;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\Exception;
use Overtrue\EasySms\Exceptions\InvalidArgumentException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Psr\Container\ContainerInterface;

class SmsService extends AbstractService
{
    /**
     * @see config/autoload/easySms.php
     */
    #[Value('easySms')]
    protected array $config = [];

    protected EasySms $easySms;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->easySms = make(EasySms::class, [$this->config]);
    }

    /**
     * 发送 - 短信.
     */
    public function send(string|array $mobile, MessageInterface|array $message, array $gateways = [])
    {
        if (! $this->isEnable()) {
            throw new BusinessException('短信配置未开启');
        }

        try {
            $this->easySms->send($mobile, $message, $gateways);
        } catch (InvalidArgumentException $e) {
            throw new BusinessException($e->getMessage());
        } catch (NoGatewayAvailableException $e) {
            /** @var Exception $exception */
            $exception = $e->getLastException();
            $this->logger->warning($e->getMessage(), ['code' => $exception->getCode()]);

            throw new BusinessException('短信发送异常');
        }
    }

    /**
     * 是否 - 启用.
     */
    protected function isEnable(): bool
    {
        return data_get($this->config, 'isEnable') === true;
    }
}
