<?php

namespace App\Entity;

use App\Repository\CouleursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CouleursRepository::class)
 */
class Couleurs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;
    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="couleur")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategories::class, inversedBy="couleurs")
     */
    private $sousCategorie;

    public function __construct()
    {   
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSousCategorie() === $this) {
                $product->setSousCategorie(null);
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
