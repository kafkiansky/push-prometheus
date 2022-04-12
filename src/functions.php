<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus;

use Kafkiansky\PushPrometheus\Metrics\Name;

/**
 * @param array<string, string> $synopsis
 */
function format(array $synopsis, Name $name, array $labels, int|float $value): string
{
    $formatted = '';

    foreach ($synopsis as $synopsisName => $synopsisValue) {
        $formatted .= "$synopsisName $synopsisValue\n";
    }

    $line = $formatted.$name.' '.$value;

    if (\count($labels) > 0) {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        $line = $formatted.$name.'{'.\implode(',', \array_map(fn (string $key, string $value): string => "$key=\"{$value}\"", \array_keys($labels), \array_values($labels))).'} '.$value;
    }

    return "$line\n";
}
