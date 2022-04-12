<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Uri;

final class DefaultUriCompiler implements UriCompiler
{
    /**
     * {@inheritdoc}
     */
    public function compile(string $host, array $groups = []): string
    {
        $uri = \rtrim($host, '/').'/metrics';

        foreach ($groups as $key => $value) {
            $uri .= "/$key/$value";
        }

        return $uri;
    }
}
