<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\DependencyInjection\Compiler;

use Odandb\MonitoringMetricsBundle\Metric\DoctrineMetric;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AddDoctrineLoggerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('doctrine.debug_data_holder')) {
            return;
        }

        $metricDefinition = (new Definition(DoctrineMetric::class))
            ->setArguments([
                new Reference('doctrine.debug_data_holder')
            ])
            ->addTag('monitoring.metric')
        ;
        $container->setDefinition('monitoring.metric.doctrine', $metricDefinition);
    }
}
