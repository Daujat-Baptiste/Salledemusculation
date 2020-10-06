<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Rubrique::class, inversedBy="articles")
     */
    private $id_rubrique;

    /**
     * @ORM\ManyToOne(targetEntity=Redacteur::class, inversedBy="articles")
     */
    private $redacteur;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIdRubrique(): ?Rubrique
    {
        return $this->id_rubrique;
    }

    public function setIdRubrique(?Rubrique $id_rubrique): self
    {
        $this->id_rubrique = $id_rubrique;

        return $this;
    }

    public function getRedacteur(): ?Redacteur
    {
        return $this->redacteur;
    }

    public function setRedacteur(?Redacteur $redacteur): self
    {
        $this->redacteur = $redacteur;

        return $this;
    }
}
