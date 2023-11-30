<?php

namespace App\Entity;

use App\Repository\CardModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardModelRepository::class)]
class CardModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cardModels', cascade: ["persist"])]
    private ?CardBrand $brand = null;

    #[ORM\Column]
    private ?string $name = null;

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

    public function getBrand(): ?CardBrand
    {
        return $this->brand;
    }

    public function setBrand(?CardBrand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }
}
