<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Kafkiansky\PushPrometheus\Metrics\Batch;
use Kafkiansky\PushPrometheus\Metrics\Counter;
use Kafkiansky\PushPrometheus\Metrics\Gauge;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use PHPUnit\Framework\TestCase;

final class BatchTest extends TestCase
{
    public function testBatchRendered(): void
    {
        $batch = new Batch([
            new Counter(new Name('requests'), new Number(10)),
            new Gauge(new Name('cases'), new Number(2))
        ]);

        $parts = \explode(\PHP_EOL, (string) $batch);
        self::assertEquals([
            '# HELP The counter for requests',
            '# TYPE requests counter',
            'requests 10',
            '# HELP The gauge for cases',
            '# TYPE cases gauge',
            'cases 2',
            '',
        ], $parts);
    }
}
