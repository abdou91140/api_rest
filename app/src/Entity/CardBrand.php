<?php

namespace App\Entity;

use App\Repository\CardBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardBrandRepository::class)]
class CardBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'name', targetEntity: CardModel::class)]
    private Collection $cardModels;

    public function __construct()
    {
        $this->cardModels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CardModel>
     */
    public function getCardModels(): Collection
    {
        return $this->cardModels;
    }

    public function addCardModel(CardModel $cardModel): static
    {
        if (!$this->cardModels->contains($cardModel)) {
            $this->cardModels->add($cardModel);
            $cardModel->setBrand($this);
        }

        return $this;
    }

    public function removeCardModel(CardModel $cardModel): static
    {
        if ($this->cardModels->removeElement($cardModel)) {
            // set the owning side to null (unless already changed)
            if ($cardModel->getName() === $this) {
                $cardModel->setBrand(null);
            }
        }

        return $this;
    }
}
