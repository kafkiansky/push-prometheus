<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Amp\Http\Client\HttpClient;
use Kafkiansky\PushPrometheus\Context;
use Kafkiansky\PushPrometheus\Metrics\Counter;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use Kafkiansky\PushPrometheus\Pusher;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

final class PusherTest extends TestCase
{
    public function testUriWasCompiledWithDefaultGroups(): void
    {
        $delegate = new InMemoryHttpClient();

        $pusher = new Pusher(new Context(host: 'https://test.pushgateway.com', groups: ['job' => 'test', 'instance' => 'k8s']), fn (): HttpClient => new HttpClient($delegate));

        wait($pusher->push(new Counter(new Name('test'), new Number(10))));

        self::assertEquals('POST', $delegate->request->getMethod());
        self::assertEquals('https://test.pushgateway.com/metrics/job/test/instance/k8s', (string) $delegate->request->getUri());
    }

    public function testUriWasCompiledWithCustomGroups(): void
    {
        $delegate = new InMemoryHttpClient();

        $pusher = new Pusher(new Context(host: 'https://test.pushgateway.com', groups: ['job' => 'test', 'instance' => 'k8s']), fn (): HttpClient => new HttpClient($delegate));

        wait($pusher->push(new Counter(name: new Name('test'), value: new Number(10), groups: ['lang' => 'php'])));

        self::assertEquals('POST', $delegate->request->getMethod());
        self::assertEquals('https://test.pushgateway.com/metrics/job/test/instance/k8s/lang/php', (string) $delegate->request->getUri());
    }

    public function testIfReplaceSetTruePutRequestWillSend(): void
    {
        $delegate = new InMemoryHttpClient();

        $pusher = new Pusher(new Context(host: 'https://test.pushgateway.com', groups: ['job' => 'test', 'instance' => 'k8s']), fn (): HttpClient => new HttpClient($delegate));

        wait($pusher->push(metric: new Counter(new Name('test'), new Number(10)), replace: true));

        self::assertEquals('PUT', $delegate->request->getMethod());
    }
}
