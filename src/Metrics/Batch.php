<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

final class Batch implements \Stringable
{
    /**
     * @psalm-param (Metric|\Stringable)[] $metrics
     */
    public function __construct(
        private array $metrics,
    ) {
    }

    public function __toString(): string
    {
        return \implode('', $this->metrics);
    }
}
