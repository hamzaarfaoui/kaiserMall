<?php

namespace App\Entity;

use App\Repository\BannersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BannersRepository::class)
 */
class Banners
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
    private $image;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTwo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isThree;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class)
     */
    private $product;

    /**
     * @ORM\OneToOne(targetEntity=ProductsList::class, mappedBy="banner", cascade={"persist", "remove"})
     */
    private $productsList;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategories::class, inversedBy="banners")
     */
    private $sousCategories;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="banners")
     */
    private $store;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsTwo(): ?bool
    {
        return $this->isTwo;
    }

    public function setIsTwo(?bool $isTwo): self
    {
        $this->isTwo = $isTwo;

        return $this;
    }

    public function getIsThree(): ?bool
    {
        return $this->isThree;
    }

    public function setIsThree(?bool $isThree): self
    {
        $this->isThree = $isThree;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProductsList(): ?ProductsList
    {
        return $this->productsList;
    }

    public function setProductsList(?ProductsList $productsList): self
    {
        // unset the owning side of the relation if necessary
        if ($productsList === null && $this->productsList !== null) {
            $this->productsList->setBanner(null);
        }

        // set the owning side of the relation if necessary
        if ($productsList !== null && $productsList->getBanner() !== $this) {
            $productsList->setBanner($this);
        }

        $this->productsList = $productsList;

        return $this;
    }

    public function getSousCategories(): ?SousCategories
    {
        return $this->sousCategories;
    }

    public function setSousCategories(?SousCategories $sousCategories): self
    {
        $this->sousCategories = $sousCategories;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getStore(): ?Stores
    {
        return $this->store;
    }

    public function setStore(?Stores $store): self
    {
        $this->store = $store;

        return $this;
    }
}
