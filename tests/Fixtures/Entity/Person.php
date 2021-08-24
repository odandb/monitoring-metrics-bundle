<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $lastName;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="persons", fetch="LAZY")
     */
    private $team;

    public function __construct(string $firstName, string $lastName, Team $team)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->team = $team;
    }

    public function getId(): int
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
