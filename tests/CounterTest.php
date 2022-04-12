<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Kafkiansky\PushPrometheus\Metrics\Counter;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use PHPUnit\Framework\TestCase;

final class CounterTest extends TestCase
{
    public function testCounterRenderedWithDefaultHelpInfo(): void
    {
        $counter = new Counter(new Name('test'), new Number(2));

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP The counter for test', $parts[0]);
        self::assertEquals('# TYPE test counter', $parts[1]);
        self::assertEquals('test 2', $parts[2]);
    }

    public function testCounterRenderedWithCustomHelpInfo(): void
    {
        $counter = new Counter(new Name('test'), new Number(2), [], 'Information about test requests.');

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP Information about test requests.', $parts[0]);
        self::assertEquals('# TYPE test counter', $parts[1]);
        self::assertEquals('test 2', $parts[2]);
    }

    public function testCounterRenderedWithLabels(): void
    {
        $counter = new Counter(new Name('test'), new Number(2), ['label_name' => 'Requests count', 'lang' => 'php'], 'Information about test requests.');

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP Information about test requests.', $parts[0]);
        self::assertEquals('# TYPE test counter', $parts[1]);
        self::assertEquals('test{label_name="Requests count",lang="php"} 2', $parts[2]);
    }
}
