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
    public static function assertQueryCountMatches(string $expectedValue, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(DoctrineMetric::HEADER_NAME),
            new ResponseConstraint\ResponseHeaderSame(DoctrineMetric::HEADER_NAME, $expectedValue)
        ), $message);
    }

    public static function assertQueryCountLessThan(string $value, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(DoctrineMetric::HEADER_NAME),
            new ResponseHeaderValueLess(DoctrineMetric::HEADER_NAME, $value)
        ), $message);
    }

    public static function assertMemoryUsageLessThan(string $value, string $message = ''): void
    {
        self::assertThatForResponse(LogicalAnd::fromConstraints(
            new ResponseConstraint\ResponseHasHeader(MemoryMetric::HEADER_NAME),
            new ResponseHeaderValueLess(MemoryMetric::HEADER_NAME, $value)
        ), $message);
    }
}
