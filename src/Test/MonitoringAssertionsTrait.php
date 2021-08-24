<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Test;

use Odandb\MonitoringMetricsBundle\Metric\DoctrineMetric;
use Odandb\MonitoringMetricsBundle\Metric\MemoryMetric;
use Odandb\MonitoringMetricsBundle\Test\Constraint\ResponseHeaderValueLess;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Bundle\FrameworkBundle\Test\BrowserKitAssertionsTrait;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

/**
 * @mixin BrowserKitAssertionsTrait
 */
trait MonitoringAssertionsTrait
{
    public static function assertQueryCountMatches(int $value, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(DoctrineMetric::HEADER_NAME),
            new ResponseConstraint\ResponseHeaderSame(DoctrineMetric::HEADER_NAME, (string) $value)
        ), $message);
    }

    public static function assertQueryCountLessThan(int $value, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(DoctrineMetric::HEADER_NAME),
            new ResponseHeaderValueLess(DoctrineMetric::HEADER_NAME, (string) $value)
        ), $message);
    }

    /**
     * @param int|float $value Value in Mb
     */
    public static function assertMemoryUsageLessThan($value, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(MemoryMetric::HEADER_NAME),
            new ResponseHeaderValueLess(MemoryMetric::HEADER_NAME, (string) $value)
        ), $message);
    }
}
