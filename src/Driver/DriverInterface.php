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
    public function lock(string $key, int $lockMilliseconds): bool;

    public function get(string $key): ?string;

    public function set(string $key, string $result): void;
}
