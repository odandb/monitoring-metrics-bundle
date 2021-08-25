<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Metric;

use Odandb\MonitoringMetricsBundle\Metric\AbstractMetric;
use Symfony\Component\HttpFoundation\Response;

class CustomMetric extends AbstractMetric
{
    public const HEADER_NAME = 'X-Monitor-Custom-Metric';

    public function metric(Response $response): void
    {
        $response->headers->set(self::HEADER_NAME, 'CustomValue');
    }

    public function reset(): void
    {
    }
}
