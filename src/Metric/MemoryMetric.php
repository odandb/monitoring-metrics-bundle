<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector;

class MemoryMetric extends AbstractMetric
{
    public const HEADER_NAME = 'X-Monitor-Memory-Usage';

    public function metric(Response $response): void
    {
        $response->headers->set(self::HEADER_NAME, (string) (memory_get_peak_usage(true) / 1024 / 1024));
    }

    public function reset(): void
    {
    }
}
