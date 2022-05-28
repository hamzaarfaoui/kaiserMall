<?php

namespace App\Entity;

use App\Repository\SousCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategoriesRepository::class)
 */
class SousCategories
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $showInIndex;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderInIndex;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hasBanner;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icone;

    /**
     * @ORM\OneToMany(targetEntity=Keywords::class, mappedBy="categorie")
     */
    private $keywords;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="sousCategories")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="sousCategorie")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=Caracteristiques::class, mappedBy="caracteristiques")
     */
    private $caracteristiques;

    /**
     * @ORM\OneToMany(targetEntity=Couleurs::class, mappedBy="sousCategorie")
     */
    private $couleurs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
        $this->couleurs = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getShowInIndex(): ?int
    {
        return $this->showInIndex;
    }

    public function setShowInIndex(?int $showInIndex): self
    {
        $this->showInIndex = $showInIndex;

        return $this;
    }

    public function getOrderInIndex(): ?int
    {
        return $this->orderInIndex;
    }

    public function setOrderInIndex(?int $orderInIndex): self
    {
        $this->orderInIndex = $orderInIndex;

        return $this;
    }

    public function getHasBanner(): ?int
    {
        return $this->hasBanner;
    }

    public function setHasBanner(?int $hasBanner): self
    {
        $this->hasBanner = $hasBanner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * @return Collection|Keywords[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keywords $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->setCategorie($this);
        }

        return $this;
    }

    public function removeKeyword(Keywords $keyword): self
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
            // set the owning side to null (unless already changed)
            if ($keyword->getCategorie() === $this) {
                $keyword->setCategorie(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

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

    /**
     * @return Collection|Caracteristiques[]
     */
    public function getCaracteristiques(): Collection
    {
        return $this->caracteristiques;
    }

    public function addCaracteristique(Caracteristiques $caracteristique): self
    {
        if (!$this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques[] = $caracteristique;
            $caracteristique->setSousCategorie($this);
        }

        return $this;
    }

    public function removeCaracteristique(Caracteristiques $caracteristique): self
    {
        if ($this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques->removeElement($caracteristique);
            // set the owning side to null (unless already changed)
            if ($caracteristique->getSousCategorie() === $this) {
                $caracteristique->setSousCategorie(null);
            }
        }

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

    /**
     * @return Collection|Couleurs[]
     */
    public function getCouleurs(): Collection
    {
        return $this->couleurs;
    }

    public function addCouleur(Couleurs $couleur): self
    {
        if (!$this->couleurs->contains($couleur)) {
            $this->couleurs[] = $couleur;
            $couleur->setSousCategorie($this);
        }

        return $this;
    }

    public function removeCouleur(Couleurs $couleur): self
    {
        if ($this->couleurs->removeElement($couleur)) {
            // set the owning side to null (unless already changed)
            if ($couleur->getSousCategorie() === $this) {
                $couleur->setSousCategorie(null);
            }
        }

        return $this;
    }
}
