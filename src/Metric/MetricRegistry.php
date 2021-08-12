<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\ResetInterface;

class MetricRegistry implements ResetInterface
{
    /**
     * @var AbstractMetric[]
     */
    protected $registry = [];

    public function addMetric(AbstractMetric $metric): void
    {
        $this->registry[] = $metric;
    }

    public function metric(Response $response): void
    {
        foreach ($this->registry as $metric) {
            $metric->metric($response);
        }
    }

    public function reset(): void
    {
        foreach ($this->registry as $registry) {
            $registry->reset();
        }
    }
}
