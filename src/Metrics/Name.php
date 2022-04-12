<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

final class Name implements \Stringable
{
    public function __construct(
        private string $name,
        private ?string $namespace = null,
        private ?string $subsystem = null
    ) {
    }

    public function __toString(): string
    {
        return \implode('_', \array_filter([
            $this->namespace,
            $this->subsystem,
            $this->name,
        ]));
    }
}
