<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Person
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $firstName;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $lastName;

    #[ORM\ManyToOne(targetEntity: Team::class, fetch: 'LAZY', inversedBy: 'persons')]
    private Team $team;

    public function __construct(string $firstName, string $lastName, Team $team)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->team = $team;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }
}
