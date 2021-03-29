<?php

namespace App\Entity;

use App\Repository\SouscrireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SouscrireRepository::class)
 */
class Souscrire
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="souscrires")
     */
    private $User;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Abonnement::class, inversedBy="souscrires")
     */
    private $Abonnement;

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->Abonnement;
    }

    public function setAbonnement(?Abonnement $Abonnement): self
    {
        $this->Abonnement = $Abonnement;

        return $this;
    }
}
