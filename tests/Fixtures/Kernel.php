<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\Configuration;
use Odandb\MonitoringMetricsBundle\MonitoringMetricsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new MonitoringMetricsBundle()
        ];
    }

    public function prepareContainer(ContainerBuilder $container): void
    {
        parent::prepareContainer($container);

        $container->setParameter('enable_lazy_ghost_objects', method_exists(Configuration::class, 'isLazyGhostObjectEnabled'));
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config.yaml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
