<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
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
    private $fullname;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pricePromotion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrView;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrAddToCart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrAddToFavorite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

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
     * @ORM\OneToMany(targetEntity=Keywords::class, mappedBy="product")
     */
    private $keywords;

    /**
     * @ORM\ManyToOne(targetEntity=Marques::class, inversedBy="products")
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity=MediasImages::class, mappedBy="product")
     */
    private $mediasImages;

    /**
     * @ORM\OneToMany(targetEntity=MediasVideos::class, mappedBy="product")
     */
    private $mediasVideos;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="products")
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategories::class, inversedBy="products")
     */
    private $sousCategorie;

    /**
     * @ORM\ManyToMany(targetEntity=Valeurs::class, inversedBy="products")
     */
    private $valeurs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=ProductsList::class, inversedBy="products")
     */
    private $listProduct;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $inListProducts;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->mediasImages = new ArrayCollection();
        $this->mediasVideos = new ArrayCollection();
        $this->valeurs = new ArrayCollection();
        $this->listProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }
    
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPricePromotion(): ?float
    {
        return $this->pricePromotion;
    }

    public function setPricePromotion(?float $pricePromotion): self
    {
        $this->pricePromotion = $pricePromotion;

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

    public function getIsDeleted(): ?int
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?int $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getNbrView(): ?int
    {
        return $this->nbrView;
    }

    public function setNbrView(?int $nbrView): self
    {
        $this->nbrView = $nbrView;

        return $this;
    }

    public function getNbrAddToCart(): ?int
    {
        return $this->nbrAddToCart;
    }

    public function setNbrAddToCart(?int $nbrAddToCart): self
    {
        $this->nbrAddToCart = $nbrAddToCart;

        return $this;
    }

    public function getNbrAddToFavorite(): ?int
    {
        return $this->nbrAddToFavorite;
    }

    public function setNbrAddToFavorite(?int $nbrAddToFavorite): self
    {
        $this->nbrAddToFavorite = $nbrAddToFavorite;

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

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(?int $qte): self
    {
        $this->qte = $qte;

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
            $keyword->setProduct($this);
        }

        return $this;
    }

    public function removeKeyword(Keywords $keyword): self
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
            // set the owning side to null (unless already changed)
            if ($keyword->getProduct() === $this) {
                $keyword->setProduct(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marques
    {
        return $this->marque;
    }

    public function setMarque(?Marques $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection|MediasImages[]
     */
    public function getMediasImages(): Collection
    {
        return $this->mediasImages;
    }

    public function addMediasImage(MediasImages $mediasImage): self
    {
        if (!$this->mediasImages->contains($mediasImage)) {
            $this->mediasImages[] = $mediasImage;
            $mediasImage->setProduct($this);
        }

        return $this;
    }

    public function removeMediasImage(MediasImages $mediasImage): self
    {
        if ($this->mediasImages->contains($mediasImage)) {
            $this->mediasImages->removeElement($mediasImage);
            // set the owning side to null (unless already changed)
            if ($mediasImage->getProduct() === $this) {
                $mediasImage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MediasVideos[]
     */
    public function getMediasVideos(): Collection
    {
        return $this->mediasVideos;
    }

    public function addMediasVideo(MediasVideos $mediasVideo): self
    {
        if (!$this->mediasVideos->contains($mediasVideo)) {
            $this->mediasVideos[] = $mediasVideo;
            $mediasVideo->setProduct($this);
        }

        return $this;
    }

    public function removeMediasVideo(MediasVideos $mediasVideo): self
    {
        if ($this->mediasVideos->contains($mediasVideo)) {
            $this->mediasVideos->removeElement($mediasVideo);
            // set the owning side to null (unless already changed)
            if ($mediasVideo->getProduct() === $this) {
                $mediasVideo->setProduct(null);
            }
        }

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

    public function getSousCategorie(): ?SousCategories
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategories $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

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
        }

        return $this;
    }

    public function removeValeur(Valeurs $valeur): self
    {
        if ($this->valeurs->contains($valeur)) {
            $this->valeurs->removeElement($valeur);
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
     * @return Collection|ProductsList[]
     */
    public function getListProduct(): Collection
    {
        return $this->listProduct;
    }

    public function addListProduct(ProductsList $listProduct): self
    {
        if (!$this->listProduct->contains($listProduct)) {
            $this->listProduct[] = $listProduct;
        }

        return $this;
    }

    public function removeListProduct(ProductsList $listProduct): self
    {
        if ($this->listProduct->contains($listProduct)) {
            $this->listProduct->removeElement($listProduct);
        }

        return $this;
    }

    public function getInListProducts(): ?int
    {
        return $this->inListProducts;
    }

    public function setInListProducts(?int $inListProducts): self
    {
        $this->inListProducts = $inListProducts;

        return $this;
    }
}
