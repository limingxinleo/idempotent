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

use Hyperf\Contract\PackerInterface;
use Idempotent\Driver\DriverInterface;
use Idempotent\Exception\IdempotentException;
use Idempotent\Serializer\PhpSerializerPacker;
use JetBrains\PhpStorm\Pure;

class Idempotent
{
    protected DriverInterface $driver;

    protected Config $config;

    protected PackerInterface $packer;

    #[Pure]
    public function __construct(DriverInterface $driver, Config $config = null, PackerInterface $packer = null)
    {
        $this->driver = $driver;
        $this->config = $config ?? Config::default();
        $this->packer = $packer ?? new PhpSerializerPacker();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function run($key, callable $callable)
    {
        $lockKey = $this->config->getPrefix() . $key;
        $resultKey = $this->config->getResultPrefix() . $key;
        $tryCount = 0;
        if (! $this->driver->lock($lockKey, $this->config->getLockMilliseconds())) {
            beginning:
            ++$tryCount;
            $result = $this->driver->get($resultKey);
            if ($result !== null) {
                return $this->packer->unpack($result);
            }

            if ($tryCount < $this->config->getTryCount()) {
                $this->wait($this->config->getWaitMilliseconds());
                goto beginning;
            }

            throw IdempotentException::tryCount();
        }

        try {
            $result = $callable();
        } catch (\Throwable $exception) {
            $this->driver->del($lockKey);
            throw $exception;
        }
        $this->driver->set($resultKey, $this->packer->pack($result), $this->config->getLockMilliseconds());
        return $result;
    }

    protected function wait(int $ms): void
    {
        if ($ms > 0) {
            usleep($ms * 1000);
        }
    }
}
