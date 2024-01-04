<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\ManyToMany(targetEntity: Outil::class, mappedBy: 'Tags')]
    private Collection $outils;

    public function __construct()
    {
        $this->outils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Outil>
     */
    public function getOutils(): Collection
    {
        return $this->outils;
    }

    public function addOutil(Outil $outil): static
    {
        if (!$this->outils->contains($outil)) {
            $this->outils->add($outil);
            $outil->addTag($this);
        }

        return $this;
    }

    public function removeOutil(Outil $outil): static
    {
        if ($this->outils->removeElement($outil)) {
            $outil->removeTag($this);
        }

        return $this;
    }
}
