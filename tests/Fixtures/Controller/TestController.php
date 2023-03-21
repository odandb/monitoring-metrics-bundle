<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity\Person;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class TestController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function personList(): JsonResponse
    {
        $persons = $this->em->createQueryBuilder()
            ->select('p')
            ->from(Person::class, 'p')
            ->leftJoin('p.team', 't')
            ->getQuery()
            ->getResult()
        ;

        return new JsonResponse(['person' => $persons]);
    }
}
