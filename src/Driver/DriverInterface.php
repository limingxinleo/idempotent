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

interface DriverInterface
{
    /**
     * 是否获得锁
     */
    public function lock(string $key, int $lockMilliseconds): bool;

    /**
     * 读取数据.
     */
    public function get(string $key): ?string;

    /**
     * 保存数据.
     */
    public function set(string $key, string $result, int $lockMilliseconds): void;
}
