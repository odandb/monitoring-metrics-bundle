<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Bridge\Doctrine\Middleware\Debug\DebugDataHolder;
use Symfony\Component\HttpFoundation\Response;

class DoctrineMetric extends AbstractMetric
{
    public const HEADER_NAME = 'X-Monitor-Doctrine-Queries';

    protected DebugDataHolder $debugDataHolder;

    public function __construct(DebugDataHolder $debugDataHolder)
    {
        $this->debugDataHolder = $debugDataHolder;
    }

    public function metric(Response $response): void
    {
        $queries = [];

        foreach ($this->debugDataHolder->getData() as $name => $data) {
            if (!isset($queries[$name])) {
                $queries[$name] = 0;
            }

            $queries[$name] += count($data);
        }

        $response->headers->set(self::HEADER_NAME, (string) array_sum($queries));
    }

    public function reset(): void
    {
        $this->debugDataHolder->reset();
    }
}
