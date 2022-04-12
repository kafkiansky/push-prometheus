# Push Prometheus.

![test](https://github.com/kafkiansky/push-prometheus/workflows/test/badge.svg?event=push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/kafkiansky/push-prometheus.svg?style=flat-square)](https://packagist.org/packages/kafkiansky/push-prometheus)

### Contents

- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [License](#license)

## Installation


```bash
composer require kafkiansky/push-prometheus
```

## Usage

Simple example with default http client:

```php
use Amp\Http\Client\Request;
use Kafkiansky\PushPrometheus\Context;
use Kafkiansky\PushPrometheus\Metrics\Counter;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use Kafkiansky\PushPrometheus\Pusher;

require_once __DIR__.'/vendor/autoload.php';

Amp\Loop::run(function (): \Generator {
    $pusher = new Pusher(new Context(host: 'https://pushgateway.test.net/', groups: [
        'job'      => 'gateway',
        'instance' => 'localhost',
    ]));

    yield $pusher->push(new Counter(new Name('test', 'namespace', 'subsystem'), new Number(2)));
});
```

With custom http client:

```php
use Amp\Http\Client\Request;
use Kafkiansky\PushPrometheus\Context;
use Kafkiansky\PushPrometheus\Metrics\Gauge;
use Kafkiansky\PushPrometheus\Metrics\Name;
use Kafkiansky\PushPrometheus\Metrics\Number;
use Kafkiansky\PushPrometheus\Pusher;
use Amp\Http\Client\HttpClient;
use Amp\Http\Client\HttpClientBuilder;

require_once __DIR__.'/vendor/autoload.php';

Amp\Loop::run(function (): \Generator {
    $pusher = new Pusher(new Context(host: 'https://pushgateway.test.net/', groups: [
        'job'      => 'gateway',
        'instance' => 'localhost',
    ]), function (): HttpClient {
        return HttpClientBuilder::buildDefault();
    });

    yield $pusher->push(new Gauge(new Name('test', 'namespace', 'subsystem'), new Number(2)));
});
```

## Testing

``` bash
$ composer test
```  

## License

The MIT License (MIT). See [License File](LICENSE) for more information.
