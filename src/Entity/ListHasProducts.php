<?php

namespace App\Entity;

use App\Repository\ListHasProductsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListHasProductsRepository::class)
 */
class ListHasProducts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProductsList::class, inversedBy="listHasProducts")
     */
    private $listProduct;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="listHasProducts")
     */
    private $product;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListProduct(): ?productsList
    {
        return $this->listProduct;
    }

    public function setListProduct(?productsList $listProduct): self
    {
        $this->listProduct = $listProduct;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
