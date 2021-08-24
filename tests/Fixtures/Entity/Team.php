<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Team
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
    private $name;

    /**
     * @var Person[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="team")
     */
    private $persons;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->persons = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Person[]|ArrayCollection
     */
    public function getPersons(): ArrayCollection
    {
        return $this->persons;
    }
}
