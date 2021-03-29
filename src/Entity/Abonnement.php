<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Souscrire::class, mappedBy="Abonnement")
     */
    private $souscrires;

    public function __construct()
    {
        $this->souscrires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Souscrire[]
     */
    public function getSouscrires(): Collection
    {
        return $this->souscrires;
    }

    public function addSouscrire(Souscrire $souscrire): self
    {
        if (!$this->souscrires->contains($souscrire)) {
            $this->souscrires[] = $souscrire;
            $souscrire->setAbonnement($this);
        }

        return $this;
    }

    public function removeSouscrire(Souscrire $souscrire): self
    {
        if ($this->souscrires->removeElement($souscrire)) {
            // set the owning side to null (unless already changed)
            if ($souscrire->getAbonnement() === $this) {
                $souscrire->setAbonnement(null);
            }
        }

        return $this;
    }
}
