<?php

declare(strict_types=1);

namespace App\Demo\Controller;

use App\Demo\Collection\TestCollection;
use App\Demo\Collection\TestResource;
use App\Demo\Request\TestRequest;
use Core\Controller\AbstractController;
use Core\Request\SearchRequest;
use Core\Service\Demo\TestService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Kernel\Response\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 测试 - 控制器.
 */
#[Controller('demo/test')]
class TestController extends AbstractController
{
    #[Inject]
    protected TestService $service;

    /**
     * 测试 - 列表.
     */
    #[GetMapping('')]
    public function index(SearchRequest $request): ResponseInterface
    {
        $test = $this->service->search($request->searchParams());

        return TestCollection::make($test);
    }

    /**
     * 测试 - 详情.
     */
    #[GetMapping('{id}')]
    public function show(int $id): ResponseInterface
    {
        $test = $this->service->getById($id);

        return TestResource::make($test);
    }

    /**
     * 测试 - 创建.
     *
     * 如果创建成功不需要返回详情数据，不需要传参，可使用 success() 方法
     * @example return Response::success()
     * ```
     * [
     *     'code' => 200,
     *     'message' => '操作成功',
     *     'data' => [],
     * ]
     * ```
     */
    #[PostMapping('')]
    public function create(TestRequest $request): ResponseInterface
    {
        $test = $this->service->create($request->validated());

        return Response::withData(TestResource::make($test));
    }

    /**
     * 测试 - 修改.
     */
    #[PutMapping('{id}')]
    public function update(TestRequest $request, int $id): ResponseInterface
    {
        $test = $this->service->getById($id);
        $test = $this->service->update($test, $request->validated(TestRequest::SCENE_UPDATE));

        return Response::withData(TestResource::make($test));
    }

    /**
     * 测试 - 删除.
     */
    #[DeleteMapping('{id}')]
    public function delete(int $id): ResponseInterface
    {
        $test = $this->service->getById($id);
        $this->service->delete($test);

        return Response::success();
    }

    /**
     * 测试 - 启用.
     */
    #[PutMapping('{id}/enable')]
    public function enable(int $id): ResponseInterface
    {
        $test = $this->service->getById($id);
        $this->service->enable($test);

        return Response::success();
    }

    /**
     * 测试 - 禁用.
     */
    #[PutMapping('{id}/disable')]
    public function disable(int $id): ResponseInterface
    {
        $test = $this->service->getById($id);
        $this->service->disable($test);

        return Response::success();
    }
}
