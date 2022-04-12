<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Amp\ByteStream\InMemoryStream;
use Amp\CancellationToken;
use Amp\Http\Client\DelegateHttpClient;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use Amp\Promise;
use Amp\Success;

final class InMemoryHttpClient implements DelegateHttpClient
{
    public ?Request $request = null;
    public function __construct(private ?Response $response = null)
    {
    }

    public function request(Request $request, CancellationToken $cancellation): Promise
    {
        return new Success($this->response ?: new Response('1.1', 200, 'OK', [], new InMemoryStream(), $this->request = $request));
    }
}
