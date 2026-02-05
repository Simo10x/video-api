<?php

namespace App\Entity;

use Symfony\Component\Serializer\Attribute\Groups;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['movie:list', 'movie:detail'])]
    private ?string $titleMovie = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['movie:list', 'movie:detail'])]
    private ?string $synopsisMovie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageCover = null;

    #[ORM\Column]
    #[Groups(['movie:list', 'movie:detail'])]
    private ?\DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:detail'])]
    private ?user $user = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'movies')]
    #[Groups(['movie:list', 'movie:detail'])]
    private Collection $categories;

    /**
     * @var Collection<int, Director>
     */
    #[ORM\ManyToMany(targetEntity: Director::class, inversedBy: 'movies')]
    #[Groups(['movie:list', 'movie:detail'])]
    private Collection $directors;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->directors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleMovie(): ?string
    {
        return $this->titleMovie;
    }

    public function setTitleMovie(string $titleMovie): static
    {
        $this->titleMovie = $titleMovie;

        return $this;
    }

    public function getSynopsisMovie(): ?string
    {
        return $this->synopsisMovie;
    }

    public function setSynopsisMovie(string $synopsisMovie): static
    {
        $this->synopsisMovie = $synopsisMovie;

        return $this;
    }

    public function getImageCover(): ?string
    {
        return $this->imageCover;
    }

    public function setImageCover(?string $imageCover): static
    {
        $this->imageCover = $imageCover;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Director>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Director $director): static
    {
        if (!$this->directors->contains($director)) {
            $this->directors->add($director);
        }

        return $this;
    }

    public function removeDirector(Director $director): static
    {
        $this->directors->removeElement($director);

        return $this;
    }
}
