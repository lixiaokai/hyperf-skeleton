<?php

declare(strict_types=1);

namespace Core\Service\User;

use Core\Constants\CaptchaType;
use Core\Contract\UserInterface;
use Core\Exception\BusinessException;
use Core\Model\Tenant;
use Core\Model\User;
use Core\Model\UserAdmin;
use Core\Repository\UserAdminRepository;
use Core\Service\AbstractService;
use Core\Service\Captcha\CaptchaService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\NotFoundException;

/**
 * 总后台用户 - 服务类.
 */
class UserAdminService extends AbstractService
{
    #[Inject]
    protected UserAdminRepository $repo;

    #[Inject]
    protected UserService $userService;

    /**
     * 总后台用户 - 列表.
     */
    public function search(array $searchParams = []): PaginatorInterface
    {
        $query = $this->repo->getQuery()
            ->with(['user', 'roles'])
            ->orderByDesc('id');

        return $this->repo->search($searchParams, $query);
    }

    /**
     * 总后台用户 - 详情.
     */
    public function getById(int $id): UserAdmin
    {
        try {
            $userAdmin = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new BusinessException('用户信息不存在');
        }

        return $userAdmin;
    }

    /**
     * 总后台用户 - 详情 ( 根据手机号 ).
     */
    public function getByPhone(string $phone): UserAdmin
    {
        return $this->repo->getByPhone($phone);
    }

    /**
     * 总后台用户 - 创建.
     */
    #[Transactional]
    public function create(Tenant $tenant, array $data, string $appId): UserAdmin|UserInterface
    {
        if (empty(data_get($data, 'username'))) {
            throw new BusinessException('用户账号不能为空');
        }
        if (empty($phone = data_get($data, 'phone'))) {
            throw new BusinessException('手机号不能为空');
        }
        if (empty($roleIds = data_get($data, 'roleIds'))) {
            throw new BusinessException('角色不能为空');
        }

        // 1. 创建|更新: 基础用户
        /* @var User $user */
        $user = $this->userService->updateOrCreateByPhone($phone, $data);

        // 2. 创建: 总后台用户
        $userAdmin = $this->repo->create([
            'id' => $user->id,
            'username' => $user->username,
            'nickname' => $user->nickname,
            'phone' => $user->phone,
            'status' => $user->status,
        ]);

        // 3. 绑定角色
        $this->userService->bindRoles($user, $roleIds, $appId, $tenant);
        // 4. 绑定应用
        $this->userService->bindApp($user, $appId);
        // 5. 绑定租户
        $this->userService->bindTenant($user, $tenant);

        return $userAdmin;
    }

    /**
     * 总后台用户 - 修改.
     *
     * 说明：修改时会同时修改 user 用户基础表
     * 注意：$data['roleIds'] 如果为空数组时则会清空和角色的关系；为 null 时才不更新角色关系
     */
    #[Transactional]
    public function update(Tenant $tenant, UserAdmin $userAdmin, array $data, string $appId = null): UserAdmin|UserInterface
    {
        // 如果角色 $data['roleIds'] 存在的话，租户或应用不能为空
        $roleIds = data_get($data, 'roleIds');
        if ($roleIds && empty($appId)) {
            throw new BusinessException('应用 ID 不能为空');
        }

        // 1. 创建|更新: 基础用户 ( 参数 1 原来的 [ 手机号 ] )
        /* @var User $user */
        $user = $this->userService->updateOrCreateByPhone($userAdmin->phone, $data);

        // 2. 绑定: 角色
        $roleIds && $this->userService->bindRoles($user, $roleIds, $appId, $tenant);

        // 3. 更新: 总后台用户
        return $this->repo->update($userAdmin, [
            'username' => $user->username,
            'nickname' => $user->nickname,
            'phone' => $user->phone,
            'status' => $user->status,
        ]);
    }

    /**
     * 总后台用户 - 删除.
     */
    public function delete(UserAdmin $userAdmin): bool
    {
        if (! $userAdmin->canDelete()) {
            throw new BusinessException('不允许删除');
        }

        return $this->repo->delete($userAdmin);
    }

    /**
     * 总后台用户 - 启用.
     */
    public function enable(UserAdmin $userAdmin): UserAdmin
    {
        return $this->repo->enable($userAdmin);
    }

    /**
     * 总后台用户 - 禁用.
     */
    public function disable(UserAdmin $userAdmin): UserAdmin
    {
        return $this->repo->disable($userAdmin);
    }

    /**
     * 总后台用户 - 重置密码.
     */
    public function resetPassword(UserAdmin $userAdmin, string $password): UserAdmin
    {
        return $this->repo->resetPassword($userAdmin, $password);
    }

    /**
     * 总后台用户 - 更换手机号.
     *
     * @param string $newPhone 新的手机号 ( 建议在验证类中提前验证除了自己不存在 )
     * @see ChangePhoneRequest::class 参考这个验证类
     */
    public function changePhone(UserAdmin $userAdmin, string $newPhone, string $code): UserAdmin
    {
        if ($userAdmin->phone === $newPhone) {
            throw new BusinessException('新手机号不能和原手机号相同');
        }
        if (! make(CaptchaService::class)->hasCode($newPhone, $code, CaptchaType::CHANGE_PHONE)) {
            throw new BusinessException('验证码 不正确');
        }

        // 数据
        $data = ['phone' => $newPhone];

        // 1. 创建|更新: 基础用户 ( 参数 1 原来的 [ 手机号 ] )
        $this->userService->updateOrCreateByPhone($userAdmin->phone, $data);

        // 2. 更新: 总后台用户
        return $this->repo->update($userAdmin, $data);
    }
}
