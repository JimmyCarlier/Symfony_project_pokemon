<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre_forum = null;

    #[ORM\ManyToOne(inversedBy: 'forums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'forum')]
    private Collection $commentaires;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $forum_context = null;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreForum(): ?string
    {
        return $this->titre_forum;
    }

    public function setTitreForum(string $titre_forum): static
    {
        $this->titre_forum = $titre_forum;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getUsername(): string
    {
        return $this->user->getUsername();
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function numberOfCommentaire(): int
    {
        return count($this->commentaires);
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setForum($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getForum() === $this) {
                $commentaire->setForum(null);
            }
        }

        return $this;
    }

    public function getForumContext(): ?string
    {
        return $this->forum_context;
    }

    public function setForumContext(string $forum_context): static
    {
        $this->forum_context = $forum_context;

        return $this;
    }
}
