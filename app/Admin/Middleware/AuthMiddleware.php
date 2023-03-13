<?php

declare(strict_types=1);

namespace App\Admin\Middleware;

use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Model\Admin;
use Core\Service\Admin\AdminService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Kernel\Service\Auth\JWTAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 总后台认证 - 中间件.
 */
class AuthMiddleware implements MiddlewareInterface
{
    #[Inject]
    protected AdminService $adminService;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uid = $this->getUid($request);
        $this->setUser($uid);

        return $handler->handle($request);
    }

    /**
     * 设置 - 用户信息上下文.
     *
     * 以便全局上调用
     */
    protected function setUser(int $uid)
    {
        $admin = $this->getUser($uid);

        Context::set(ContextKey::UID, $uid);
        Context::set(ContextKey::ADMIN, $admin);
        Context::set(ContextKey::USER, $admin->user);
    }

    /**
     * 获取 - 用户信息.
     */
    protected function getUser(int $uid): Admin
    {
        $admin = $this->adminService->get($uid);
        if ($admin->isDisable()) {
            throw new BusinessException('该用户已被禁用，请联系管理员');
        }

        return $admin;
    }

    /**
     * 获取 - uid.
     *
     * 通过 JWT Token 获取
     */
    protected function getUid(ServerRequestInterface $request): int
    {
        $jwtToken = JWTAuth::getClientToken($request);
        $jwtPayload = JWTAuth::decode($jwtToken);

        return $jwtPayload->uid;
    }
}
