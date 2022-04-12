<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Uri;

interface UriCompiler
{
    /**
     * @psalm-param non-empty-string $host
     * @psalm-param array<string, string> $groups
     *
     * @psalm-return non-empty-string
     */
    public function compile(string $host, array $groups = []): string;
}
