<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Amount = null;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Position::class)]
    private Collection $position;

    public function __construct()
    {
        $this->position = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    /**
     * @return Collection<int, Position>
     */
    public function getPosition(): Collection
    {
        return $this->position;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->position->contains($position)) {
            $this->position->add($position);
            $position->setBudget($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->position->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getBudget() === $this) {
                $position->setBudget(null);
            }
        }

        return $this;
    }
}
