<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Metric;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Bridge\Doctrine\Middleware\Debug\DebugDataHolder;
use Symfony\Component\HttpFoundation\Response;

class DoctrineMetric extends AbstractMetric
{
    public const HEADER_NAME = 'X-Monitor-Doctrine-Queries';

    protected ?DebugDataHolder $debugDataHolder;

    /**
     * @var DebugStack[]
     */
    private array $loggers = [];

    public function __construct(?DebugDataHolder $debugDataHolder = null)
    {
        $this->debugDataHolder = $debugDataHolder;
    }

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

        if (null !== $this->debugDataHolder) {
            foreach ($this->debugDataHolder->getData() as $name => $data) {
                if (!isset($queries[$name])) {
                    $queries[$name] = 0;
                }

                $queries[$name] += count($data);
            }

            $response->headers->set(self::HEADER_NAME, (string) array_sum($queries));

            return;
        }

        foreach ($this->loggers as $name => $logger) {
            if (!isset($queries[$name])) {
                $queries[$name] = 0;
            }

            $queries[$name] += count($logger->queries);
        }

        $response->headers->set(self::HEADER_NAME, (string) array_sum($queries));
    }

    public function reset(): void
    {
        if (null !== $this->debugDataHolder) {
            $this->debugDataHolder->reset();

            return;
        }

        foreach ($this->loggers as $logger) {
            $logger->queries = [];
            $logger->currentQuery = 0;
        }
    }
}
