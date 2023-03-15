<?php

declare(strict_types=1);

namespace Kernel\Service\Auth;

use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Kernel\Exception\BusinessException;
use Kernel\Exception\UnauthorizedException;
use UnexpectedValueException;

/**
 * JWT ( Json Web Token ) - 服务类.
 */
class JWTAuth
{
    /**
     * 获取 - 请求 UID.
     */
    public static function uid(): int
    {
        static $uid;
        ! $uid && $uid = JWTAuth::decode(JWTUtil::getRequestToken())->uid;

        return $uid;
    }

    /**
     * 获取 - 某用户 token.
     */
    public static function token(int $uid, int $daysExp = null): JWToken
    {
        $JWTPayload = JWTPayload::make(['uid' => $uid]);
        $daysExp && $JWTPayload->setExp($daysExp);

        return self::encode($JWTPayload);
    }

    /**
     * 编码 - JWT.
     *
     * @see JWTServiceTest::testEncode()
     */
    public static function encode(JWTPayload $payload): JWToken
    {
        $token = JWT::encode($payload->toArray(), self::key(), 'HS256');

        return JWToken::make($token, $payload); // 字符串转成类
    }

    /**
     * 解码 - JWT.
     *
     * @param string $jwtToken 已编码的 JWT 字符串
     */
    public static function decode(string $jwtToken): JWTPayload
    {
        try {
            JWT::$leeway = 60; // 当前时间减去 60，留点余地
            $payloadData = JWT::decode($jwtToken, new Key(self::key(), 'HS256'));

            return JWTPayload::make($payloadData);
        } catch (SignatureInvalidException $e) { // 签名验证失败
            $message = 'token 验证失败，请重新登录';
        } catch (BeforeValidException $e) {
            $message = 'token 未生效，请重新登录';
        } catch (ExpiredException $e) {
            $message = 'token 已过期，请重新登录';
        } catch (UnexpectedValueException $e) {
            $message = 'token 无效，请重新登录';
        } catch (BusinessException $e) {
            $message = $e->getMessage();
        } catch (Exception $e) {
            $message = 'token 未知错误，请重新登录';
        }

        throw new UnauthorizedException($message);
    }

    /**
     * 获取 - JWT Key.
     */
    protected static function key(): string
    {
        $key = config('jwt.key');
        if (empty($key)) {
            throw new BusinessException('配置文件 ( config/autoload/jwt.php ) 未设置');
        }

        return $key;
    }
}
