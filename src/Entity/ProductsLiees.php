<?php

namespace App\Entity;

use App\Repository\ProductsLieesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsLieesRepository::class)
 */
class ProductsLiees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="productInList")
     */
    private $productMain;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $relation;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class)
     */
    private $productInList;

    public function __construct()
    {
        $this->productInList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductMain(): ?Products
    {
        return $this->productMain;
    }

    public function setProductMain(?Products $productMain): self
    {
        $this->productMain = $productMain;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(?string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProductInList(): Collection
    {
        return $this->productInList;
    }

    public function addProductInList(Products $productInList): self
    {
        if (!$this->productInList->contains($productInList)) {
            $this->productInList[] = $productInList;
        }

        return $this;
    }

    public function removeProductInList(Products $productInList): self
    {
        $this->productInList->removeElement($productInList);

        return $this;
    }
}
