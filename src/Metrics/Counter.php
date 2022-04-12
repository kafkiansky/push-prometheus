<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

final class Counter extends Metric
{
    private const TYPE = 'counter';

    protected function type(): string
    {
        return self::TYPE;
    }
}
