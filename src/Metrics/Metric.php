<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Metrics;

use function Kafkiansky\PushPrometheus\format;

abstract class Metric implements \Stringable
{
    /**
     * @param array<string, string> $groups
     */
    final public function __construct(
        private Name $name,
        private Number $value,
        private array $labels = [],
        private ?string $help = null,
        public readonly array $groups = [],
    ) {
    }

    public function __toString(): string
    {
        $type = $this->type();

        return format([
            '# HELP' => $this->help ?: "The $type for $this->name",
            '# TYPE' => "$this->name $type",
        ], $this->name, $this->labels, $this->value->value);
    }

    abstract protected function type(): string;
}
