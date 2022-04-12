<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

final class Gauge extends Metric
{
    private const TYPE = 'gauge';

    protected function type(): string
    {
        return self::TYPE;
    }
}
