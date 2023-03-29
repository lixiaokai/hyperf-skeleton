<?php

namespace Core\Service\User;

use Core\Constants\ContextKey;
use Core\Exception\BusinessException;
use Core\Service\AbstractService;
use Hyperf\Context\Context;
use Kernel\Helper\TreeHelper;

/**
 * 总后台用户 - 菜单 - 服务类.
 */
class UserAdminMenuService extends AbstractService
{
    /**
     * 获取 - 我的菜单树.
     */
    public function getMenuTrees(): array
    {
        $userAdmin = Context::get(ContextKey::USER_ADMIN);
        if ($userAdmin === null) {
            throw new BusinessException('用户未登录');
        }

        return TreeHelper::toTrees($userAdmin->getMenus()->toArray());
    }
}
