<?php

declare(strict_types=1);

namespace Kernel\Service\Collector\Result;

/**
 * 路由值 - 结果类.
 */
class RouteResult
{
    /**
     * @var string 服务名称 ( 例：http )
     */
    public string $server;

    /**
     * @var string 首节路径 ( 例：user )
     *
     * 比如：$this->route = '/user/{id}' 那么前缀则为 user
     */
    public string $firstPath = '';

    /**
     * @var string 请求方式 ( 例：GET POST PUT DELETE )
     */
    public string $method;

    /**
     * @var string 路由 ( 例：/user/{id} )
     */
    public string $route;

    /**
     * @var string 动作 ( 例：App\Controller\UserController::show )
     */
    public string $action;

    public function __construct(array $result)
    {
        foreach ($result as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }

        $this->setFirstPath();
    }

    public static function make(...$parameters): self
    {
        return new static(...$parameters);
    }

    public function setFirstPath(): void
    {
        // Todo: 待优化
        $this->firstPath = data_get(explode('/', $this->route), 1, '');
    }
}
