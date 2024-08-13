<?php

namespace App\Entity;

use App\Repository\PokemonElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonElementRepository::class)]
class PokemonElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_element = null;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\OneToMany(targetEntity: Pokemon::class, mappedBy: 'pokemon_element1')]
    private Collection $pokemon;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\OneToMany(targetEntity: Pokemon::class, mappedBy: 'pokemon_element2')]
    private Collection $pokemon_element2;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
        $this->pokemon_element2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomElement(): ?string
    {
        return $this->nom_element;
    }

    public function setNomElement(string $nom_element): static
    {
        $this->nom_element = $nom_element;

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
            $pokemon->setPokemonElement1($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokemonElement1() === $this) {
                $pokemon->setPokemonElement1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemonElement2(): Collection
    {
        return $this->pokemon_element2;
    }

    public function addPokemonElement2(Pokemon $pokemonElement2): static
    {
        if (!$this->pokemon_element2->contains($pokemonElement2)) {
            $this->pokemon_element2->add($pokemonElement2);
            $pokemonElement2->setPokemonElement2($this);
        }

        return $this;
    }

    public function removePokemonElement2(Pokemon $pokemonElement2): static
    {
        if ($this->pokemon_element2->removeElement($pokemonElement2)) {
            // set the owning side to null (unless already changed)
            if ($pokemonElement2->getPokemonElement2() === $this) {
                $pokemonElement2->setPokemonElement2(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom_element;
    }
}
