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

use Idempotent\Idempotent;

/**
 * @internal
 * @coversNothing
 */
class IdempotentTest extends AbstractTestCase
{
    public function testRunTwice()
    {
        $this->runCoroutine(function () {
            $key = uniqid();
            $result = uniqid();
            $runCount = 0;
            go(function () use ($key, $result, &$runCount) {
                $idempotent = new Idempotent($this->newRedisDriver());
                $assert = $idempotent->run($key, static function () use ($result, &$runCount) {
                    ++$runCount;
                    sleep(2);
                    return $result;
                });
                $this->assertSame($assert, $result);
            });

            $assert = wait(function () use ($key, &$runCount) {
                $idempotent = new Idempotent($this->newRedisDriver());
                return $idempotent->run($key, static function () use (&$runCount) {
                    return ++$runCount;
                });
            });

            $this->assertSame($result, $assert);
            $this->assertTrue($runCount === 1);
        });
    }
}
