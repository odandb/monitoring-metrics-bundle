<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\EventListener;

use Odandb\MonitoringMetricsBundle\Metric\MetricRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MonitoringListener implements EventSubscriberInterface
{
    protected MetricRegistry $metricRegistry;

    public function __construct(MetricRegistry $metricRegistry)
    {
        $this->metricRegistry = $metricRegistry;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $route = $event->getRequest()->attributes->get('_route');
        if (null === $route || str_starts_with($route, '_')) {
            return;
        }

        $this->metricRegistry->metric($event->getResponse());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -90],
        ];
    }
}
