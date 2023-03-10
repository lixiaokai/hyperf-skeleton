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
        $this->setUser();

        return $handler->handle($request);
    }

    /**
     * 设置 - 用户信息上下文.
     *
     * 以便全局上调用
     */
    protected function setUser()
    {
        $admin = $this->getUser();

        Context::set(ContextKey::UID, $admin->id);
        Context::set(ContextKey::ADMIN, $admin);
        Context::set(ContextKey::USER, $admin->user);
    }

    /**
     * 获取 - 用户信息.
     */
    protected function getUser(): Admin
    {
        $admin = $this->adminService->getById(self::getUid());
        if ($admin->isDisable()) {
            throw new BusinessException('账号已禁用，请联系管理员');
        }

        return $admin;
    }

    /**
     * 获取 - uid.
     *
     * 通过 JWT Token 获取
     */
    protected static function getUid(): int
    {
        return self::injectUidForDev() ?? JWTAuth::uid();
    }

    /**
     * 注入 - uid.
     *
     * 开发环境可临时取消下面注释来注入 uid 实现快速切换用户
     */
    protected static function injectUidForDev(): ?int
    {
        // if (config('app_env') === 'dev') {
        //     return 1;
        // }

        return null;
    }
}
