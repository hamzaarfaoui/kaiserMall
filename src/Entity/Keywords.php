<?php

namespace App\Entity;

use App\Repository\KeywordsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KeywordsRepository::class)
 */
class Keywords
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
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="keywords")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategories::class, inversedBy="keywords")
     */
    private $categorie;

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

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCategorie(): ?SousCategories
    {
        return $this->categorie;
    }

    public function setCategorie(?SousCategories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
