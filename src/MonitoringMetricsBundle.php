<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle;

use Odandb\MonitoringMetricsBundle\DependencyInjection\Compiler\AddDoctrineLoggerPass;
use Odandb\MonitoringMetricsBundle\DependencyInjection\Compiler\MetricRegistryPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonitoringMetricsBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AddDoctrineLoggerPass());
        $container->addCompilerPass(new MetricRegistryPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, -10);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
