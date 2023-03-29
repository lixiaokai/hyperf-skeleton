<?php

declare(strict_types=1);

namespace Core\Service\Rbac;

use Core\Model\Tenant;
use Core\Repository\TenantRepository;
use Core\Service\AbstractService;
use Hyperf\Di\Annotation\Inject;
use Kernel\Exception\BusinessException;
use Kernel\Exception\NotFoundException;

/**
 * 租户 - 服务类.
 */
class TenantService extends AbstractService
{
    #[Inject]
    protected TenantRepository $repo;

    /**
     * 租户 - 详情.
     */
    public function getById(int $id): Tenant
    {
        try {
            $tenant = $this->repo->getById($id);
        } catch (NotFoundException) {
            throw new BusinessException('该租户信息不存在');
        }

        return $tenant;
    }

    /**
     * 租户 - 创建.
     */
    public function create(array $data): Tenant
    {
        return $this->repo->create($data);
    }

    /**
     * 租户 - 修改 - 基础信息.
     */
    public function update(Tenant $tenant, array $data): Tenant
    {
        return $this->repo->update($tenant, $data);
    }

    /**
     * 租户 - 删除.
     */
    public function delete(Tenant $tenant): bool
    {
        if (! $tenant->canDelete()) {
            throw new BusinessException('该租户不允许删除');
        }

        return $this->repo->delete($tenant);
    }

    /**
     * 租户 - 启用.
     */
    public function enable(Tenant $tenant): Tenant
    {
        if ($tenant->canEnable()) {
            throw new BusinessException('不允许操作');
        }

        return $this->repo->enable($tenant);
    }

    /**
     * 租户 - 禁用.
     */
    public function disable(Tenant $tenant): Tenant
    {
        if ($tenant->canDisable()) {
            throw new BusinessException('不允许操作');
        }

        return $this->repo->disable($tenant);
    }
}
