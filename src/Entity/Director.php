<?php

namespace App\Entity;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\DirectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DirectorRepository::class)]
#[UniqueEntity(fields: ['nameDirector', 'firstnameDirector'])]

class Director
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['movie:list', 'movie:detail', 'director:read'])]
    private ?string $nameDirector = null;

    #[ORM\Column(length: 50)]
    #[Groups(['movie:list', 'movie:detail', 'director:read'])]
    private ?string $firstnameDirector = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dayOfBirth = null;

    #[ORM\Column(length: 50)]
    private ?string $countryDirector = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'directors')]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDirector(): ?string
    {
        return $this->nameDirector;
    }

    public function setNameDirector(string $nameDirector): static
    {
        $this->nameDirector = $nameDirector;

        return $this;
    }

    public function getFirstnameDirector(): ?string
    {
        return $this->firstnameDirector;
    }

    public function setFirstnameDirector(string $firstnameDirector): static
    {
        $this->firstnameDirector = $firstnameDirector;

        return $this;
    }

    public function getDayOfBirth(): ?\DateTime
    {
        return $this->dayOfBirth;
    }

    public function setDayOfBirth(\DateTime $dayOfBirth): static
    {
        $this->dayOfBirth = $dayOfBirth;

        return $this;
    }

    public function getCountryDirector(): ?string
    {
        return $this->countryDirector;
    }

    public function setCountryDirector(string $countryDirector): static
    {
        $this->countryDirector = $countryDirector;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addDirector($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeDirector($this);
        }

        return $this;
    }
}
