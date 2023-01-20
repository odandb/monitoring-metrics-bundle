<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\DependencyInjection\Compiler;

use Odandb\MonitoringMetricsBundle\Metric\MetricRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MetricRegistryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('monitoring.metrics')) {
            return;
        }

        $definition = $container->findDefinition('monitoring.metrics');

        $metricServices = $container->findTaggedServiceIds('monitoring.metric');

        foreach ($metricServices as $id => $tags) {
            $definition->addMethodCall('addMetric', [new Reference($id)]);
        }
    }
}
