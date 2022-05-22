<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $price;
    
    /**
     * @MongoDB\Field(type="float")
     */
    protected $pricePromotion;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $content;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $isDeleted;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $nbrView;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $nbrAddToCart;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $nbrAddToFavorite;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $status;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $qte;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $position;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $createdAt;
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;
    
    /**      
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Please, upload the Article image as an image file.")
     * @Assert\File(mimeTypes={ "image/png","image/jpg""image/jpeg" })       
     */
    protected $image;
    
    
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="MediasImages", mappedBy="product") */
    protected $mediasImages = array();
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="MediasVideos", mappedBy="product") */
    protected $mediasVideos = array();
    
    /** @MongoDB\ReferenceMany(targetDocument="Valeurs", mappedBy="products") */
    protected $valeurs;
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="Keywords", mappedBy="product") */
    protected $keywords = array();
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Marques", inversedBy="products") */
    protected $marque;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="SousCategories", inversedBy="products") */
    protected $sousCategorie;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Stores", inversedBy="products") */
    protected $store;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**      * @return mixed      */
    public function getName()
    {
        return $this->name;
    }
    /**      * @param mixed $name      */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**      * @return mixed      */
    public function getPrice()
    {
        return $this->price;
    }
    /**      * @param mixed $price      */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**      * @return mixed      */
    public function getPricePromotion()
    {
        return $this->pricePromotion;
    }
    /**      * @param mixed $pricePromotion      */
    public function setPricePromotion($pricePromotion)
    {
        $this->pricePromotion = $pricePromotion;
    }
    
    /**      * @return mixed      */
    public function getContent()
    {
        return $this->content;
    }
    /**      * @param mixed $content      */
    public function setContent($content)
    {
        $this->content = $content;
    }
    /**      * @return mixed      */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**      * @param mixed $updatedAt      */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**      * @return mixed      */
    public function getImage()
    {
        return $this->image;
    }
    /**      * @param mixed $image      */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /**      * @return mixed      */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**      * @param mixed $createdAt      */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**      * @param mixed $isDeleted      */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }
    
    /**      * @return mixed      */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    /**      * @param mixed $nbrView      */
    public function setNbrView($nbrView)
    {
        $this->nbrView = $nbrView;
    }
    
    /**      * @return mixed      */
    public function getNbrView()
    {
        return $this->nbrView;
    }
    
    /**      * @param mixed $nbrAddToCart      */
    public function setNbrAddToCart($nbrAddToCart)
    {
        $this->nbrAddToCart = $nbrAddToCart;
    }
    
    /**      * @return mixed      */
    public function getNbrAddToCart()
    {
        return $this->nbrAddToCart;
    }
    
    /**      * @param mixed $nbrAddToFavorite      */
    public function setNbrAddToFavorite($nbrAddToFavorite)
    {
        $this->nbrAddToFavorite = $nbrAddToFavorite;
    }
    
    /**      * @return mixed      */
    public function getNbrAddToFavorite()
    {
        return $this->nbrAddToFavorite;
    }
    
    
    
    /**      * @return mixed      */
    public function getStatus()
    {
        return $this->status;
    }
    /**      * @param mixed $status      */
    public function setIsStatus($status)
    {
        $this->status = $status;
    }
    
    /**      * @return mixed      */
    public function getQte()
    {
        return $this->qte;
    }
    /**      * @param mixed $qte      */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }
    
    /**      * @param mixed $position      */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    /**      * @return mixed      */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add mediaImage
     *
     * @param App\Document\MediasImages $mediaImage
     */
    public function addMediaImage(MediasImages $mediaImage)
    {
        $this->mediasImages[] = $mediaImage;
    }
 
    /**
     * Remove mediaImage
     *
     * @param App\Document\MediasImages $mediaImage
     */
    public function removeMediaImage(MediasImages $mediaImage)
    {
        $this->mediasImages->removeElement($mediaImage);
    }
 
    /**
     * Get MediasImages
     *
     * @return \Doctrine\Common\Collections\Collection $MediasImages
     */
    public function getMediasImages()
    {
        return $this->mediasImages;
    }
    
    /**
     * Add mediaVideo
     *
     * @param App\Document\MediasVideos $mediaVideo
     */
    public function addMediasVideos(MediasVideos $mediaVideo)
    {
        $this->mediasVideos[] = $mediaVideo;
    }
 
    /**
     * Remove mediaVideo
     *
     * @param App\Document\MediasVideos $mediasVideo
     */
    public function removeMediasVideos(MediasVideos $mediasVideo)
    {
        $this->mediasVideos->removeElement($mediasVideo);
    }
 
    /**
     * Get mediasVideos
     *
     * @return \Doctrine\Common\Collections\Collection $mediasVideos
     */
    public function getMediasVideos()
    {
        return $this->mediasVideos;
    }
    
    /**
     * Add valeur
     *
     * @param App\Document\Valeurs $valeur
     */
    public function addValeur(Valeurs $valeur)
    {
        $this->valeurs[] = $valeur;
    }
    /**
     * Remove valeur
     *
     * @param App\Document\Valeurs $valeur
     */
    public function removeValeur(Valeurs $valeur)
    {
        $this->valeurs->removeElement($valeur);
    }
    /**
     * Get valeurs
     *
     * @return \Doctrine\Common\Collections\Collection $valeurs
     */
    public function getValeurs()
    {
        return $this->valeurs;
    }
    
    /**
     * Add keyword
     *
     * @param App\Document\Keywords $keyword
     */
    public function addKeyword(Keywords $keyword)
    {
        $this->keywords[] = $keyword;
    }
 
    /**
     * Remove keyword
     *
     * @param App\Document\Keywords $keyword
     */
    public function removeKeyword(Keywords $keyword)
    {
        $this->keywords->removeElement($keyword);
    }
 
    /**
     * Get keywords
     *
     * @return \Doctrine\Common\Collections\Collection $MediasImages
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }
    /**
     * @param Marques $marque
     *
     * @return self
     */
    public function setMarque(Marques $marque)
    {
        $this->marque = $marque;
        return $this;
    }
    
    
    /**
     * @param SousCategories $sousCategorie
     *
     * @return self
     */
    public function setSousCategorie(SousCategories $sousCategorie)
    {
        $this->sousCategorie = $sousCategorie;
        return $this;
    }
    
    /**
     * Get sousCategorie
     *
     */
    public function getSousCategorie()
    {
        return $this->sousCategorie;
    }
    
    /**
     * @param Stores $store
     *
     * @return self
     */
    public function setStore(Stores $store)
    {
        $this->store = $store;
        return $this;
    }
    
    /**
     * Get store
     *
     */
    public function getStore()
    {
        return $this->store;
    }
}
