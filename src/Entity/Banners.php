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
}
