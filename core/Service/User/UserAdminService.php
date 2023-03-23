<?php

declare(strict_types=1);

namespace Core\Service\User;

use Core\Constants\CaptchaType;
use Core\Contract\UserInterface;
use Core\Exception\BusinessException;
use Core\Model\Role;
use Core\Model\User;
use Core\Model\UserAdmin;
use Core\Repository\UserAdminRepository;
use Core\Service\AbstractService;
use Core\Service\Captcha\CaptchaService;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Di\Annotation\Inject;

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
            ->with('user')
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
        } catch (BusinessException) {
            throw new BusinessException('用户信息不存在');
        }

        return $userAdmin;
    }

    /**
     * 总后台用户 - 详情.
     */
    public function getByUserId(int $id): UserAdmin
    {
        return $this->repo->getByUserId($id);
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
    public function create(array $data): UserAdmin|UserInterface
    {
        $phone = data_get($data, 'phone');
        if (empty($phone)) {
            throw new BusinessException('手机号不能为空');
        }

        // 1. 创建|更新: 基础用户
        return $this->userService->updateOrCreateByPhone($phone, $data, function (User $user) use ($data) {
            // 2. 创建: 总后台用户
            $userAdmin = $this->repo->create([
                'userId' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'password' => data_get($data, 'password'),
                'status' => $user->status,
            ]);

            // 3. 更新: 用户和用户组关系
            $userAdmin->roles()->sync(data_get($data, 'roleIds'));

            return $userAdmin;
        });
    }

    /**
     * 总后台用户 - 修改.
     *
     * 说明：修改时会同时修改 user 用户基础表
     * 注意：$data['roleIds'] 如果为空数组时则会清空和角色的关系；为 null 时才不更新角色关系
     */
    #[Transactional]
    public function update(UserAdmin $userAdmin, array $data): UserAdmin|UserInterface
    {
        $phone = $userAdmin->phone; // 原来的 [ 手机号 ]

        // 1. 创建|更新: 基础用户
        return $this->userService->updateOrCreateByPhone($phone, $data, function (User $user) use ($userAdmin, $data) {
            // 2. 更新: 用户和用户组关系
            $userAdmin->roles()->sync(data_get($data, 'roleIds'));

            // 3. 更新: 总后台用户
            return $this->repo->update($userAdmin, [
                'name' => $user->name,
                'phone' => $user->phone,
                'status' => $user->status,
            ]);
        });
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
     * 说明：$phone 必须在验证类中提前验证除了自己不存在
     *
     * @see ChangePhoneRequest::class 比如这个验证类，验证手机号除了自己之外不存在
     */
    public function changePhone(UserAdmin $userAdmin, string $phone, string $code): UserAdmin
    {
        if ($userAdmin->phone === $phone) {
            throw new BusinessException('新手机号和原手机号相同');
        }
        if (! make(CaptchaService::class)->hasCode($phone, $code, CaptchaType::CHANGE_PHONE)) {
            throw new BusinessException('验证码 不正确');
        }

        return $this->update($userAdmin, ['phone' => $phone]);
    }
}
