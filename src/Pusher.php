<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus;

use Amp\Http\Client\Connection\UnlimitedConnectionPool;
use Amp\Http\Client\HttpClient;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Interceptor\SetRequestHeader;
use Amp\Http\Client\Interceptor\SetRequestTimeout;
use Amp\Http\Client\Request;
use Amp\Promise;
use Kafkiansky\PushPrometheus\Metrics\Metric;
use Kafkiansky\PushPrometheus\Uri\DefaultUriCompiler;
use Kafkiansky\PushPrometheus\Uri\UriCompiler;
use function Amp\call;

final class Pusher
{
    private HttpClient $httpClient;
    private Context $context;
    private UriCompiler $uriCompiler;

    /**
     * @psalm-param (callable(Context): HttpClient)|null $httpClientBuilder
     */
    public function __construct(Context $context, ?callable $httpClientBuilder = null, UriCompiler $uriCompiler = new DefaultUriCompiler())
    {
        $this->context = $context;
        $this->httpClient = ($httpClientBuilder ?: $this->default(...))($context);
        $this->uriCompiler = $uriCompiler;
    }

    public function push(Metric|\Stringable $metric, bool $replace = false): Promise
    {
        return call(function () use ($metric, $replace): \Generator {
            $groups = $this->context->groups;

            if ($metric instanceof Metric) {
                $groups = \array_merge($groups, $metric->groups);
            }

            $uri = $this->uriCompiler->compile($this->context->host, $groups);

            $response = yield $this->httpClient->request(new Request($uri, $replace ? 'PUT' : 'POST', (string) $metric));

            if ((($response->getStatus() / 100) | 0) !== 2) {
                throw new CannotPushMetrics(\vsprintf('Unexpected status code "%d" received from pushgateway with body: "%s."', [
                    $response->getStatus(),
                    yield $response->getBody()->buffer(),
                ]));
            }
        });
    }

    private function default(Context $context): HttpClient
    {
        return (new HttpClientBuilder())
            ->retry($context->retryLimit)
            ->skipDefaultUserAgent()
            ->followRedirects(0)
            ->intercept(new SetRequestTimeout($context->connectTimeout, $context->handshakeTimeout, $context->transferTimeout))
            ->intercept(new SetRequestHeader('Content-Type', 'text/plain'))
            ->usingPool(new UnlimitedConnectionPool())
            ->build();
    }
}
