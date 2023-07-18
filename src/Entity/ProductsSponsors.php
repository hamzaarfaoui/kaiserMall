<?php

namespace App\Entity;

use App\Repository\ProductsSponsorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsSponsorsRepository::class)
 */
class ProductsSponsors
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
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $periode;

    /**
     * @ORM\Column(type="integer")
     */
    private $idProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $idStore;

    public function __construct()
    {
        $this->idProduct = new ArrayCollection();
        $this->idStore = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Products[]
     */
    public function getIdProduct(): Collection
    {
        return $this->idProduct;
    }

    public function addIdProduct(Products $idProduct): self
    {
        if (!$this->idProduct->contains($idProduct)) {
            $this->idProduct[] = $idProduct;
            $idProduct->setProductsSponsors($this);
        }

        return $this;
    }

    public function removeIdProduct(Products $idProduct): self
    {
        if ($this->idProduct->removeElement($idProduct)) {
            // set the owning side to null (unless already changed)
            if ($idProduct->getProductsSponsors() === $this) {
                $idProduct->setProductsSponsors(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stores[]
     */
    public function getIdStore(): Collection
    {
        return $this->idStore;
    }

    public function addIdStore(Stores $idStore): self
    {
        if (!$this->idStore->contains($idStore)) {
            $this->idStore[] = $idStore;
            $idStore->setProductsSponsors($this);
        }

        return $this;
    }

    public function removeIdStore(Stores $idStore): self
    {
        if ($this->idStore->removeElement($idStore)) {
            // set the owning side to null (unless already changed)
            if ($idStore->getProductsSponsors() === $this) {
                $idStore->setProductsSponsors(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(?int $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function setIdProduct(int $idProduct): self
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    public function setIdStore(int $idStore): self
    {
        $this->idStore = $idStore;

        return $this;
    }
}
