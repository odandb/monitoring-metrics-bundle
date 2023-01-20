<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddDoctrineLoggerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('monitoring.metric.doctrine')) {
            return;
        }

        // With DebugDataHolder, no need to use logger
        if ($container->has('doctrine.debug_data_holder')) {
            return;
        }

        $definition = $container->getDefinition('monitoring.metric.doctrine');

        $connections = $container->getParameter('doctrine.connections');
        $loggers = [];
        foreach ($connections as $name => $connection) {
            $profilingLogger = null;
            if ($container->has(sprintf('doctrine.dbal.logger.backtrace.%s', $name))) {
                $profilingLogger = new Reference(sprintf('doctrine.dbal.logger.backtrace.%s', $name));
            }

            if ($container->has(sprintf('doctrine.dbal.logger.profiling.%s', $name))) {
                $profilingLogger = new Reference(sprintf('doctrine.dbal.logger.profiling.%s', $name));
            }

            if (null !== $profilingLogger) {
                $loggers[] = [$name, $profilingLogger];
            }
        }

        if (0 === \count($loggers)) {
            $container->removeDefinition('monitoring.metric.doctrine');

            return;
        }

        foreach ($loggers as $logger) {
            $definition->addMethodCall('addLogger', $logger);
        }
    }
}
