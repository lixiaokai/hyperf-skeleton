<?php

declare(strict_types=1);

namespace Core\Service\Captcha;

use Core\Constants\CaptchaType;
use Core\Exception\BusinessException;
use Core\Service\AbstractService;
use Exception;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

/**
 * 验证码 - 服务类.
 */
class CaptchaService extends AbstractService
{
    #[Inject]
    protected Redis $redis;

    /**
     * 有效期 - 秒数.
     *
     * 默认：600 秒 ( 既 10 分钟 )
     */
    protected int $expire = 600;

    /**
     * 生成 code.
     *
     * @see CaptchaCodeServiceTest::testGenCode()
     */
    public function genCode(string $mobile, string $type): CodeResult
    {
        if (! CaptchaType::has($type)) {
            throw new BusinessException("验证码类型 {$type} 是无效的");
        }

        try {
            // 生成 4 位随机数字字符串，左侧补 0
            $code = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } catch (Exception) {
            $code = '0000';
        }

        $this->set($mobile, $code, $type);

        return new CodeResult($code, $this->expire);
    }

    /**
     * 验证 - code.
     */
    public function hasCode(string $mobile, string $code, string $type): bool
    {
        $codeCache = $this->get($mobile, $type);
        $isExists = $codeCache === $code;

        if (! $isExists) {
            // 失败：记录日志
            $this->logger->warning('验证码错误', [
                'mobile' => $mobile,
                'code' => $code,
                'codeCache' => $codeCache,
            ]);
        }

        // 成功：删除缓存
        // $this->delCode($mobile, $type);

        return $isExists;
    }

    /**
     * 能否 - 重新生成 code ?
     *
     * 说明：60 秒到期后才可以再次获取.
     *
     * @see CaptchaServiceTest::testCanRenewGenCode()
     */
    public function canRenewGenCode(string $mobile, string $type, int $keepSecond = 60): bool
    {
        $ttl = $this->redis->ttl(self::key($mobile, $type)); // 剩余存活秒数

        if ($ttl === -2) {
            // 如果 key 不存在 ( key 等于 -2 )
            return true;
        }
        if ($ttl === -1) {
            // 如果 key 永不过期 ( key 等于 -1 )
            return true;
        }
        $liveSecond = $this->expire - $ttl; // 已存活秒数
        if ($liveSecond > ($keepSecond - 2)) {
            // 如果 [ 已存活秒数 ] 大于 [ 保留秒数 ]，则表示允许重新生成
            // 为了避免前端倒计时获取后获取失败，这里提前 2 秒允许重新生成
            return true;
        }

        return false;
    }

    /**
     * 设置验证码 到 Redis.
     *
     * @param string $mobile 手机号
     * @param string $code   验证码
     * @param string $type   验证类型
     */
    protected function set(string $mobile, string $code, string $type): bool
    {
        return $this->redis->set(self::key($mobile, $type), $code, ['ex' => $this->expire]);
    }

    /**
     * 获取验证码 从 Redis.
     *
     * @param string $mobile 手机号
     * @param string $type   验证类型
     */
    protected function get(string $mobile, string $type): string
    {
        return (string) $this->redis->get(self::key($mobile, $type));
    }

    /**
     * 删除验证码 从 Redis.
     *
     * @param string $mobile 手机号
     * @param string $type   验证类型
     */
    protected function del(string $mobile, string $type): void
    {
        $this->redis->del(self::key($mobile, $type));
    }

    /**
     * 获取 - key.
     *
     * 设置到 redis 的唯一 key
     *
     * @param string $mobile 手机号
     * @param string $type   验证类型
     */
    protected static function key(string $mobile, string $type): string
    {
        return "captcha:{$type}:{$mobile}";
    }
}
