<?php

namespace App\Entity;

use App\Repository\ProductsListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsListRepository::class)
 */
class ProductsList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="productsLists")
     */
    private $store;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\OneToOne(targetEntity=Sliders::class, inversedBy="productsList", cascade={"persist", "remove"})
     */
    private $slider;

    /**
     * @ORM\OneToOne(targetEntity=Banners::class, inversedBy="productsList", cascade={"persist", "remove"})
     */
    private $banner;

    /**
     * @ORM\OneToMany(targetEntity=ListHasProducts::class, mappedBy="listProduct")
     */
    private $listHasProducts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->listHasProducts = new ArrayCollection();
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

    public function getStore(): ?Stores
    {
        return $this->store;
    }

    public function setStore(?Stores $store): self
    {
        $this->store = $store;

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

    public function getSlider(): ?Sliders
    {
        return $this->slider;
    }

    public function setSlider(?Sliders $slider): self
    {
        $this->slider = $slider;

        return $this;
    }

    public function getBanner(): ?Banners
    {
        return $this->banner;
    }

    public function setBanner(?Banners $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * @return Collection|ListHasProducts[]
     */
    public function getListHasProducts(): Collection
    {
        return $this->listHasProducts;
    }

    public function addListHasProduct(ListHasProducts $listHasProduct): self
    {
        if (!$this->listHasProducts->contains($listHasProduct)) {
            $this->listHasProducts[] = $listHasProduct;
            $listHasProduct->setListProduct($this);
        }

        return $this;
    }

    public function removeListHasProduct(ListHasProducts $listHasProduct): self
    {
        if ($this->listHasProducts->removeElement($listHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($listHasProduct->getListProduct() === $this) {
                $listHasProduct->setListProduct(null);
            }
        }

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}