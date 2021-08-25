<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Functional;

use Odandb\MonitoringMetricsBundle\Test\MonitoringAssertionsTrait;
use Odandb\MonitoringMetricsBundle\Tests\Fixtures\Metric\CustomMetric;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    use MonitoringAssertionsTrait;

    /** @var KernelBrowser */
    protected $client;

    protected function setUp() : void
    {
        $this->client = self::createClient();
    }

    public function testPersonList(): void
    {
        $this->client->request('GET', '/person');

        self::assertResponseIsSuccessful();

        // Metric
        self::assertQueryCountMatches(1);
        self::assertMemoryUsageLessThan(40);

        // Custom Metric
        self::assertResponseHasHeader(CustomMetric::HEADER_NAME);
    }
}
