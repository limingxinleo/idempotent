<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use Idempotent\Driver\RedisDriver;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    public function newRedisDriver(): RedisDriver
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        return new RedisDriver($redis);
    }

    public function runCoroutine(callable $callable)
    {
        if (extension_loaded('swoole')) {
            \Swoole\Coroutine\run($callable);
        } else {
            $callable();
        }
    }
}
