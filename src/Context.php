<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus;

final class Context
{
    /**
     * Connect timeout in milliseconds.
     */
    private const DEFAULT_CONNECT_TIMEOUT = 2000;

    /**
     * Handshake timeout in milliseconds.
     */
    private const DEFAULT_HANDSHAKE_TIMEOUT = 2000;

    /**
     * Transfer timeout in milliseconds.
     */
    private const DEFAULT_TRANSFER_TIMEOUT = 2000;

    /**
     * HTTP retry limit.
     */
    private const DEFAULT_RETRY_LIMIT = 5;

    /**
     * @var non-empty-string
     */
    public readonly string $host;

    /**
     * @param array<string, string> $groups
     */
    public function __construct(
        string $host,
        public readonly array $groups = [],
        public readonly int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        public readonly int $handshakeTimeout = self::DEFAULT_HANDSHAKE_TIMEOUT,
        public readonly int $transferTimeout = self::DEFAULT_TRANSFER_TIMEOUT,
        public readonly int $retryLimit = self::DEFAULT_RETRY_LIMIT,
    ) {
        if ('' === $host) {
            throw new \InvalidArgumentException('Host should not be empty.');
        }

        $this->host = $host;
    }
}
