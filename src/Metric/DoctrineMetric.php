<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\HttpFoundation\Response;

class DoctrineMetric extends AbstractMetric
{
    public const HEADER_NAME = 'X-Monitor-Doctrine-Queries';

    /**
     * @var DebugStack[]
     */
    private $loggers = [];

    /**
     * Adds the stack logger for a connection.
     */
    public function addLogger(string $name, DebugStack $logger): void
    {
        $this->loggers[$name] = $logger;
    }

    public function metric(Response $response): void
    {
        $queries = [];
        foreach ($this->loggers as $name => $logger) {
            if (!isset($queries[$name])) {
                $queries[$name] = 0;
            }

            $queries[$name] += count($logger->queries);
        }

        $response->headers->set(self::HEADER_NAME, array_sum($queries));
    }

    public function reset(): void
    {
        foreach ($this->loggers as $logger) {
            $logger->queries = [];
            $logger->currentQuery = 0;
        }
    }
}
