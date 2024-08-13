<?php

namespace App\Entity;

use App\Repository\RarityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RarityRepository::class)]
class Rarity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rarity_name = null;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\OneToMany(targetEntity: Pokemon::class, mappedBy: 'pokemon_rarity')]
    private Collection $pokemon;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRarityName(): ?string
    {
        return $this->rarity_name;
    }

    public function setRarityName(string $rarity_name): static
    {
        $this->rarity_name = $rarity_name;

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(Pokemon $pokemon): static
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon->add($pokemon);
            $pokemon->setPokemonRarity($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokemonRarity() === $this) {
                $pokemon->setPokemonRarity(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->rarity_name;
    }
}
