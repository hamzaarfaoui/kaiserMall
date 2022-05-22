<?php

namespace App\Entity;

use App\Repository\CaracteristiquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaracteristiquesRepository::class)
 */
class Caracteristiques
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=Valeurs::class, mappedBy="caracteristique")
     */
    private $valeurs;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategories::class, inversedBy="caracteristiques")
     */
    private $sousCategorie;

    public function __construct()
    {
        $this->valeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Valeurs[]
     */
    public function getValeurs(): Collection
    {
        return $this->valeurs;
    }

    public function addValeur(Valeurs $valeur): self
    {
        if (!$this->valeurs->contains($valeur)) {
            $this->valeurs[] = $valeur;
            $valeur->setCaracteristique($this);
        }

        return $this;
    }

    public function removeValeur(Valeurs $valeur): self
    {
        if ($this->valeurs->contains($valeur)) {
            $this->valeurs->removeElement($valeur);
            // set the owning side to null (unless already changed)
            if ($valeur->getCaracteristique() === $this) {
                $valeur->setCaracteristique(null);
            }
        }

        return $this;
    }

    public function getSousCategorie(): ?SousCategories
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategories $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }
}
