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
namespace Idempotent;

use JetBrains\PhpStorm\Pure;

class Config
{
    protected string $prefix = 'i:l:';

    protected string $resultPrefix = 'i:r:';

    protected int $lockMilliseconds = 5000;

    protected int $tryCount = 10;

    protected int $waitMilliseconds = 300;

    public function __construct(string $prefix = null, string $resultPrefix = null, int $lockMilliseconds = null, int $tryCount = null, int $waitMilliseconds = null)
    {
        isset($prefix) && $this->prefix = $prefix;
        isset($resultPrefix) && $this->resultPrefix = $resultPrefix;
        isset($lockMilliseconds) && $this->lockMilliseconds = $lockMilliseconds;
        isset($tryCount) && $this->tryCount = $tryCount;
        isset($waitMilliseconds) && $this->waitMilliseconds = $waitMilliseconds;
    }

    #[Pure]
    public static function default(): static
    {
        return new Config();
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getResultPrefix(): string
    {
        return $this->resultPrefix;
    }

    public function getLockMilliseconds(): int
    {
        return $this->lockMilliseconds;
    }

    public function getTryCount(): int
    {
        return $this->tryCount;
    }

    public function getWaitMilliseconds(): int
    {
        return $this->waitMilliseconds;
    }
}
