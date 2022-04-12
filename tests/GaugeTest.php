<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Kafkiansky\PushPrometheus\Metrics\Gauge;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use PHPUnit\Framework\TestCase;

final class GaugeTest extends TestCase
{
    public function testGaugeRenderedWithDefaultHelpInfo(): void
    {
        $counter = new Gauge(new Name('test'), new Number(2));

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP The gauge for test', $parts[0]);
        self::assertEquals('# TYPE test gauge', $parts[1]);
        self::assertEquals('test 2', $parts[2]);
    }

    public function testGaugeRenderedWithCustomHelpInfo(): void
    {
        $counter = new Gauge(new Name('test'), new Number(2), [], 'Information about test requests.');

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP Information about test requests.', $parts[0]);
        self::assertEquals('# TYPE test gauge', $parts[1]);
        self::assertEquals('test 2', $parts[2]);
    }

    public function testGaugeRenderedWithLabels(): void
    {
        $counter = new Gauge(new Name('test'), new Number(2), ['label_name' => 'Requests gauge', 'lang' => 'php'], 'Information about test requests.');

        $parts = \explode(\PHP_EOL, (string) $counter);
        self::assertEquals('# HELP Information about test requests.', $parts[0]);
        self::assertEquals('# TYPE test gauge', $parts[1]);
        self::assertEquals('test{label_name="Requests gauge",lang="php"} 2', $parts[2]);
    }
}
