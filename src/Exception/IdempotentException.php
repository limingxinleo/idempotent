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
namespace Idempotent\Exception;

use JetBrains\PhpStorm\Pure;

class IdempotentException extends \RuntimeException
{
    #[Pure]
    public static function tryCount(): self
    {
        return new IdempotentException('Lock wait count exceeded.');
    }
}
