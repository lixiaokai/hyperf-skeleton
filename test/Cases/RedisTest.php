<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use Hyperf\Codec\Json;
use Hyperf\Context\ApplicationContext;
use Hyperf\Redis\Redis;
use PHPUnit\Framework\TestCase;

/**
 * Redis - 测试.
 *
 * @internal
 * @coversNothing
 */
class RedisTest extends TestCase
{
    private Redis $redis;

    public function setUp(): void
    {
        parent::setUp();
        $this->redis = ApplicationContext::getContainer()->get(Redis::class);
    }

    /**
     * 测试 - 字符串缓存.
     */
    public function testStringCache()
    {
        $key = 'user:1';
        $val = Json::encode(['id' => 1, 'name' => 'admin']);

        // 设置缓存，缓存时间为 10 秒
        $res = $this->redis->set($key, $val, 10); // SET user:1 'admin'
        self::assertTrue($res); // 断言为 true

        // ex: 设置过期时间为单位为 [ 秒 ]
        // $this->redis->set($key, $val, ['ex' => 10]); // SET user:1 'admin' EX 10
        // $this->redis->set($key, $val, 10);           // SET user:1 'admin' EX 10 ( 等同于上一行 )

        // px: 设置过期时间为单位为 [ 毫秒 ]
        // $this->redis->set($key, $val, ['px' => 10 * 1000]); // SET user:1 'admin' PX 10000

        // nx: 键不存在才设置
        // $this->redis->set($key, $val, ['nx']);             // SET user:1 'admin' NX
        // $this->redis->set($key, $val, ['nx', 'ex' => 10]); // SET user:1 'admin' NX EX 10

        // xx: 键存在时才设置
        // $this->redis->set($key, $val, ['xx']);             // SET user:1 'admin' XX
        // $this->redis->set($key, $val, ['xx', 'ex' => 10]); // SET user:1 'admin' XX EX 10

        // 获取缓存
        // GET user:1
        $res = $this->redis->get($key);
        self::assertEquals($val, $res);

        // 批量设置
        // $this->redis->mset([
        //     'user:1' => ['id' => 1, 'name' => 'admin'],
        //     'user:2' => ['id' => 2, 'name' => 'manager'],
        // ]);
    }

    /**
     * 测试 - 计数器.
     *
     * 命令：incr/incrBy/decr/decrBy
     * 注意：值必须为数字字符串或数字才可以
     */
    public function testStringIncr()
    {
        // 自增 +1 并返回自增后的值
        // 注意：如果键 key 不存在，那么它的值会先被初始化为 0， 然后再执行 INCR 命令 +1，结果为 1
        $key = 'user:total';
        $this->redis->del($key);
        $res = $this->redis->incr($key); // INCR user:total
        self::assertEquals(1, $res); // 断言为 1

        // 键存在，但值无法被解释为数字
        $key = 'user:total:string';
        $res = $this->redis->set($key, 'testString');
        self::assertTrue($res); // 断言为 true
        $res = $this->redis->incr($key);
        self::assertFalse($res); // 断言为 false ( 由于 key 的值不能解释为数字 )

        // 自增 +10
        $key = 'user:total';
        $userTotal = $this->redis->get($key);
        $res = $this->redis->incrBy($key, 10); // INCRBY user:total 10
        self::assertEquals($userTotal + 10, $res); // 断言为 +10

        // 自减 -1
        // 注意：如果键 key 不存在，那么它的值会先被初始化为 0， 然后再执行 DECR 命令 -1，结果为 -1
        $key = 'user:total:decr';
        $this->redis->del($key);
        $res = $this->redis->decr($key); // DECR user:total:decr
        self::assertEquals(-1, $res); // 断言为 -1

        self::assertTrue(true);
    }
}
