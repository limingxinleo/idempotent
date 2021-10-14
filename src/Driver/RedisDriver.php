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
namespace Idempotent\Driver;

class RedisDriver implements DriverInterface
{
    /**
     * @var \Redis
     */
    protected $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function lock(string $key, int $lockMilliseconds): bool
    {
        return $this->redis->set($key, '1', ['NX', 'PX' => $lockMilliseconds]) === true;
    }

    public function get(string $key): ?string
    {
        $result = $this->redis->get($key);
        if ($result === false) {
            return null;
        }
        return $result;
    }

    public function set(string $key, string $result): void
    {
        $this->redis->set($key, $result);
    }
}
