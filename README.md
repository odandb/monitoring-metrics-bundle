# Monitoring Metrics Bundle

## Introduction

This bundle provides some metric in the response header and additional assertions for the functional tests.

It collects the following metrics :

* Number of Doctrine Query
* Memory Usage

## Install

### Step 1: Download the Bundle

```console
composer require odandb/monitoring-metrics-bundle --dev
```

Caution : This bundle must be installed only in dev or/and test environment.

### Step 2: Enable the Bundle

```php
// config/bundle.php

return [
    // ...
    Odandb\MonitoringMetricsBundle\MonitoringMetricsBundle::class => ['dev' => true, 'test' => true],
];
```

## Usage

Add the `MonitoringAssertionsTrait` trait to your test-class and you can start asserting response.

```php
use Odandb\MonitoringMetricsBundle\Test\MonitoringAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FooTest extends WebTestCase
{
    use MonitoringAssertionsTrait;
    
    protected $client;
    
    protected function setUp() : void
    {
        $this->client = self::createClient();
    }
    
    public function testBar()
    {
        $this->client->request('GET', '/foo/bar');

        self::assertResponseIsSuccessful();
        
        // available assertions/methods
        self::assertQueryCountMatches(5); // query doctrine should be exactly 5.
        self::assertQueryCountLessThan(5); // query doctrine should be less than 5
        self::assertMemoryUsageLessThan(10.4); // the memory used should be less than 10.4mb
    }
}
```

## Metric

TODO

## Create your own metric

To create your own metric, you will need to extend the [AbstractMetric](./src/Metric/AbstractMetric.php) class.

Each metric needs to implement the `metric` method, which retrieves the information and adds it to the headers of the response.
