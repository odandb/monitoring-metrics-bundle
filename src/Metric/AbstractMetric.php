<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\ResetInterface;

abstract class AbstractMetric implements ResetInterface
{
    abstract public function metric(Response $response): void;
}
