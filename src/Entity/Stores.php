<?php

namespace App\Entity;

use App\Repository\StoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoresRepository::class)
 */
class Stores
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
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

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
    private $imageCouverture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrView;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="store")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=Marchands::class, inversedBy="stores")
     */
    private $marchand;

    /**
     * @ORM\OneToMany(targetEntity=TelephonesStore::class, mappedBy="store")
     */
    private $telephonesStore;

    /**
     * @ORM\OneToMany(targetEntity=AdressesStore::class, mappedBy="store")
     */
    private $adressesStore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=ProductsList::class, mappedBy="store")
     */
    private $productsLists;

    /**
     * @ORM\OneToMany(targetEntity=Banners::class, mappedBy="store")
     */
    private $banners;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->telephonesStore = new ArrayCollection();
        $this->adressesStore = new ArrayCollection();
        $this->productsLists = new ArrayCollection();
        $this->banners = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getImageCouverture(): ?string
    {
        return $this->imageCouverture;
    }

    public function setImageCouverture(?string $imageCouverture): self
    {
        $this->imageCouverture = $imageCouverture;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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
            $product->setStore($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getStore() === $this) {
                $product->setStore(null);
            }
        }

        return $this;
    }

    public function getMarchand(): ?Marchands
    {
        return $this->marchand;
    }

    public function setMarchand(?Marchands $marchand): self
    {
        $this->marchand = $marchand;

        return $this;
    }

    /**
     * @return Collection|TelephonesStore[]
     */
    public function getTelephonesStore(): Collection
    {
        return $this->telephonesStore;
    }

    public function addTelephonesStore(TelephonesStore $telephonesStore): self
    {
        if (!$this->telephonesStore->contains($telephonesStore)) {
            $this->telephonesStore[] = $telephonesStore;
            $telephonesStore->setStore($this);
        }

        return $this;
    }

    public function removeTelephonesStore(TelephonesStore $telephonesStore): self
    {
        if ($this->telephonesStore->contains($telephonesStore)) {
            $this->telephonesStore->removeElement($telephonesStore);
            // set the owning side to null (unless already changed)
            if ($telephonesStore->getStore() === $this) {
                $telephonesStore->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdressesStore[]
     */
    public function getAdressesStore(): Collection
    {
        return $this->adressesStore;
    }

    public function addAdressesStore(AdressesStore $adressesStore): self
    {
        if (!$this->adressesStore->contains($adressesStore)) {
            $this->adressesStore[] = $adressesStore;
            $adressesStore->setStore($this);
        }

        return $this;
    }

    public function removeAdressesStore(AdressesStore $adressesStore): self
    {
        if ($this->adressesStore->contains($adressesStore)) {
            $this->adressesStore->removeElement($adressesStore);
            // set the owning side to null (unless already changed)
            if ($adressesStore->getStore() === $this) {
                $adressesStore->setStore(null);
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
     * @return Collection|ProductsList[]
     */
    public function getProductsLists(): Collection
    {
        return $this->productsLists;
    }

    public function addProductsList(ProductsList $productsList): self
    {
        if (!$this->productsLists->contains($productsList)) {
            $this->productsLists[] = $productsList;
            $productsList->setStore($this);
        }

        return $this;
    }

    public function removeProductsList(ProductsList $productsList): self
    {
        if ($this->productsLists->contains($productsList)) {
            $this->productsLists->removeElement($productsList);
            // set the owning side to null (unless already changed)
            if ($productsList->getStore() === $this) {
                $productsList->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Banners[]
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banners $banner): self
    {
        if (!$this->banners->contains($banner)) {
            $this->banners[] = $banner;
            $banner->setStore($this);
        }

        return $this;
    }

    public function removeBanner(Banners $banner): self
    {
        if ($this->banners->removeElement($banner)) {
            // set the owning side to null (unless already changed)
            if ($banner->getStore() === $this) {
                $banner->setStore(null);
            }
        }

        return $this;
    }
}
