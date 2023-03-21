<?php

declare(strict_types=1);

namespace Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Team
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $name;

    /**
     * @var ArrayCollection<int, Person>
     */
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Person::class)]
    private Collection $persons;

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
     * @return ArrayCollection<int, Person>
     */
    public function getPersons(): ArrayCollection
    {
        return $this->persons;
    }
}
