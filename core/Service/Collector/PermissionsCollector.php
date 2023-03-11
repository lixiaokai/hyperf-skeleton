<?php

declare(strict_types=1);

namespace Core\Service\Collector;

use Core\Model\Permission;
use Exception;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Collection;
use Kernel\Annotation\Permission\AttachPermissions;
use Kernel\Exception\BusinessException;
use Kernel\Service\Collector\Result\RouteResult;
use Kernel\Service\Collector\RoutesCollector;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionMethod;

/**
 * 权限 - 收集器.
 */
class PermissionsCollector
{
    /**
     * 所有路由.
     *
     * @var Collection|RouteResult[]
     */
    private array|Collection $routes;

    /**
     * 附加权限.
     */
    private Collection $attachPermissions;

    private DocBlockFactory $docFactory;

    public function __construct()
    {
        $this->docFactory = DocBlockFactory::createInstance();
        $this->routes = make(RoutesCollector::class)->handle();
        $this->attachPermissions = self::getAttachPermissions();
    }

    /**
     * 执行.
     *
     * @see PermissionsCollectorTest::testHandle()
     */
    #[Transactional]
    public function handle(): void
    {
        $saveData = $this->buildSaveData();

        // 1. 软删除全部数据
        Permission::query()->delete();
        // 2. 批量更新全部数据 ( 存在的数据则去掉软删除 )
        Permission::insertOnDuplicateKey($saveData);
    }

    /**
     * 获取 - 附加路由权限.
     *
     * 说明：有些权限节点需要多个权限组合，这时就需要用到附加路由权限.
     * @example
     * ```
     *  [
     *    'App\Admin\Controller\AppController::show' => [
     *      'GET:/admin/app',
     *      'POST:/admin/app'
     *    ]
     *  ]
     * ```
     * @see PermissionsCollectorTest::testGetAdditionalPermissions()
     */
    public static function getAttachPermissions(): Collection
    {
        return collect(AnnotationCollector::getMethodsByAnnotation(AttachPermissions::class))
            ->map(function (array $item) {
                /* @var AttachPermissions $annotation */
                ['class' => $class, 'method' => $method, 'annotation' => $annotation] = $item;

                return [
                    'action' => $class . '::' . $method,
                    'routes' => $annotation->routes,
                ];
            })->pluck('routes', 'action');
    }

    /**
     * 组装 - 入库数据.
     */
    protected function buildSaveData(): array
    {
        return $this->routes
            ->filter(fn (RouteResult $routeResult) => $this->isAllowable($routeResult))
            ->sortBy('action')
            ->map(function (RouteResult $routeResult) {
                // 附加路由
                $attachRoutes = $this->getAttachRoutes($routeResult->action);

                // 路由备注
                [$controller, $method] = explode('::', $routeResult->action);
                $desc = $this->getRouteDesc($controller, $method);

                // 注意：name 字段在这里不更新
                return [
                    'platform' => $routeResult->firstPath, // 终端平台
                    'route' => $routeResult->method . ':' . $routeResult->route, // 路由
                    'attach_routes' => Json::encode($attachRoutes), // 附加路由
                    'desc' => $desc, // 备注
                    'deleted_at' => null, // 软删除
                ];
            })
            ->values()
            ->all();
    }

    /**
     * 获取 - 附加路由权限.
     */
    protected function getAttachRoutes(string $action): array
    {
        $attachRoutes = $this->attachPermissions->get($action, []);

        // 附加路由检查，避免不小心填错了
        if (! empty($attachRoutes)) {
            foreach ($attachRoutes as $route) {
                if (! $this->routes->has($route)) {
                    throw new BusinessException("附加路由 {$route} 不存在");
                }
            }
        }

        return $attachRoutes;
    }

    /**
     * 获取 - 控制器第一行注释.
     */
    protected function getRouteDesc(string $controller, string $method): string
    {
        try {
            $method = new ReflectionMethod($controller, $method);
        } catch (Exception) {
            return '';
        }

        $docBlock = $this->docFactory->create($method->getDocComment());

        return rtrim(trim($docBlock->getSummary(), '* '), '.');
    }

    /**
     * 是否 - 允许的.
     */
    protected function isAllowable(RouteResult $routeResult): bool
    {
        // 如果 [ 操作动作 ] 是 [ 闭包 ] 则跳过
        if ($routeResult->action === 'Closure') {
            return false;
        }

        return true;
    }
}
