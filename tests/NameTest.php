<?php

declare(strict_types=1);

namespace Kafkiansky\PushPrometheus\Tests;

use Kafkiansky\PushPrometheus\Metrics\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function provideNameParts(): \Generator
    {
        yield ['name', 'name', null, null];
        yield ['namespace_name', 'name', 'namespace', null];
        yield ['namespace_subsystem_name', 'name', 'namespace', 'subsystem'];
    }

    /**
     * @dataProvider provideNameParts
     */
    public function testNameRendered(string $result, string $name, ?string $namespace = null, ?string $subsystem = null): void
    {
        self::assertEquals($result, new Name($name, $namespace, $subsystem));
    }
}
