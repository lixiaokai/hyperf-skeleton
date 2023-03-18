<?php

declare(strict_types=1);

namespace Core\Aspect;

use Core\Annotation\LoginLimit;
use Core\Exception\BusinessException;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * 登录限制 - 切面.
 */
#[Aspect]
class LoginLimitAspect extends AbstractAspect
{
    /**
     * 切入注解.
     */
    public array $annotations = [
        LoginLimit::class,
    ];

    #[Inject]
    protected CacheInterface $cache;

    protected ProceedingJoinPoint $proceedingJoinPoint;

    protected LoginLimit $config;

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $this->proceedingJoinPoint = $proceedingJoinPoint;

        // 1. 调用前进行某些处理

        // 获取 - 配置.
        $config = $this->getConfig();
        $message = '您的操作太频繁，请 ' . $this->config->lockSeconds . ' 后再试';

        // 获取相关参数
        $id = $this->request->input($config->id); // 请求的唯一标识 ( 例如：手机号、邮箱、账号等 )
        $loginAttemptsKey = $this->getLoginAttemptsKey($id, $config->prefix); // 登录次数 key
        $loginLockKey = $this->getLoginLockKey($id, $config->prefix); // 登录锁定 key

        // 登录计数 ( 监控时间内的计数 )
        $attempts = $this->cache->get($loginAttemptsKey) + 1;
        $this->cache->set($loginAttemptsKey, $attempts, $config->watchSeconds);
        $this->logger->info("{$loginAttemptsKey} {$config->watchSeconds} 秒内第 {$attempts} 次登录"); // 记录日志

        // 如果锁定则抛出错误
        if ($this->cache->has($loginLockKey)) {
            throw new BusinessException($message);
        }
        // 如果超过最大次数，则锁定并抛出错误
        if ($attempts > $config->maxAttempts) {
            $this->cache->set($loginLockKey, 1, $config->lockSeconds); // 锁定
            throw new BusinessException($message);
        }

        // 2. 调用原方法并获得结果
        $result = $this->proceedingJoinPoint->process();

        // 3. 调用后进行某些处理

        // 登录成功后清除缓存记录
        // 说明：如果登录错误在前面就会抛出错误，不会执行到这里，只有登录成功才会执行到这里
        $this->cache->deleteMultiple([$loginAttemptsKey, $loginLockKey]);

        return $result;
    }

    /**
     * 获取 - 指定类方法注解 ( 即配置 ).
     */
    protected function getConfig(): LoginLimit
    {
        $this->config = AnnotationCollector::getClassMethodAnnotation(
            $this->proceedingJoinPoint->className,
            $this->proceedingJoinPoint->methodName
        )[LoginLimit::class];

        return $this->config;
    }

    /**
     * 获取 - 登录次数 key.
     */
    protected function getLoginAttemptsKey(string $id, string $prefix = ''): string
    {
        return $prefix . ':login:attempts:' . $id;
    }

    /**
     * 获取 - 登录锁定 key.
     */
    protected function getLoginLockKey(string $id, string $prefix = ''): string
    {
        return $prefix . ':login:lock:' . $id;
    }
}
