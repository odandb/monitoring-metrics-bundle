<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Odandb\MonitoringMetricsBundle\EventListener\MonitoringListener;
use Odandb\MonitoringMetricsBundle\Metric\AbstractMetric;
use Odandb\MonitoringMetricsBundle\Metric\DoctrineMetric;
use Odandb\MonitoringMetricsBundle\Metric\MemoryMetric;
use Odandb\MonitoringMetricsBundle\Metric\MetricRegistry;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->instanceof(AbstractMetric::class)
            ->tag('monitoring.metric')

        ->set('monitoring.metrics', MetricRegistry::class)

        ->set('monitoring.metric.memory', MemoryMetric::class)
            ->tag('monitoring.metric')

        ->set('monitoring.listener', MonitoringListener::class)
            ->args([
                new Reference('monitoring.metrics'),
            ])
            ->tag('kernel.event_subscriber')
    ;
};
