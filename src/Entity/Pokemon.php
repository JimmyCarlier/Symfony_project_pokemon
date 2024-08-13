<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Le nom ne peut pas contenir de chiffres'
    )]
    private ?string $nom_pokemon = null;

    #[ORM\Column]
    private ?int $hp = null;

    #[ORM\Column]
    private ?int $atk = null;

    #[ORM\Column]
    private ?int $def = null;

    /**
     * @var Collection<int, Location>
     */
    #[ORM\ManyToMany(targetEntity: Location::class, inversedBy: 'pokemon')]
    private Collection $location;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    private ?PokemonElement $pokemon_element1 = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon_element2')]
    private ?PokemonElement $pokemon_element2 = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    private ?Rarity $pokemon_rarity = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    private ?User $user = null;


    public function __construct()
    {
        $this->location = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPokemon(): ?string
    {
        return $this->nom_pokemon;
    }

    public function setNomPokemon(string $nom_pokemon): static
    {
        $this->nom_pokemon = $nom_pokemon;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getAtk(): ?int
    {
        return $this->atk;
    }

    public function setAtk(int $atk): static
    {
        $this->atk = $atk;

        return $this;
    }

    public function getDef(): ?int
    {
        return $this->def;
    }

    public function setDef(int $def): static
    {
        $this->def = $def;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->location->contains($location)) {
            $this->location->add($location);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        $this->location->removeElement($location);

        return $this;
    }

    public function getPokemonElement1(): ?PokemonElement
    {
        return $this->pokemon_element1;
    }

    public function setPokemonElement1(?PokemonElement $pokemon_element1): static
    {
        $this->pokemon_element1 = $pokemon_element1;

        return $this;
    }

    public function getPokemonElement2(): ?PokemonElement
    {
        return $this->pokemon_element2;
    }

    public function setPokemonElement2(?PokemonElement $pokemon_element2): static
    {
        $this->pokemon_element2 = $pokemon_element2;

        return $this;
    }

    public function getPokemonRarity(): ?Rarity
    {
        return $this->pokemon_rarity;
    }

    public function setPokemonRarity(?Rarity $pokemon_rarity): static
    {
        $this->pokemon_rarity = $pokemon_rarity;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
