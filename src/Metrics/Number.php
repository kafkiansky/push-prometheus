<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

final class Number
{
    public readonly int|float $value;

    public function __construct(int|float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("Metric number value must be greater or equal to zero.");
        }

        $this->value = $value;
    }
}
