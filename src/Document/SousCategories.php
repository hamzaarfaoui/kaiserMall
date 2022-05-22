<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class SousCategories
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
     * @MongoDB\Field(type="string")
     */
    protected $content;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $status;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $showInIndex;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $orderInIndex;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $hasBanner;
    
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
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Please, upload the Article image as an image file.")
     * @Assert\File(mimeTypes={ "image/png","image/jpg""image/jpeg" })       
     */
    protected $icone;
    
    /** @MongoDB\ReferenceMany(targetDocument="Products", mappedBy="sousCategorie") */
    protected $products;
    
    /** @MongoDB\ReferenceMany(targetDocument="Caracteristiques", mappedBy="sousCategorie") */
    protected $caracteristiques;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Categories", inversedBy="sousCategories") */
    protected $categorie;
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="Keywords", mappedBy="categorie") */
    protected $keywords = array();
    
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
    public function getIcone()
    {
        return $this->icone;
    }
    /**      * @param mixed $icone      */
    public function setIcone($icone)
    {
        $this->icone = $icone;
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
    public function getShowInIndex()
    {
        return $this->showInIndex;
    }
    /**      * @param mixed $showInIndex      */
    public function setShowInIndex($showInIndex)
    {
        $this->showInIndex = $showInIndex;
    }
    
    /**      * @return mixed      */
    public function getOrderInIndex()
    {
        return $this->orderInIndex;
    }
    /**      * @param mixed $orderInIndex      */
    public function setOrderInIndex($orderInIndex)
    {
        $this->orderInIndex = $orderInIndex;
    }
    
    /**      * @return mixed      */
    public function getHasBanner()
    {
        return $this->hasBanner;
    }
    /**      * @param mixed $hasBanner     */
    public function setHasBanner($hasBanner)
    {
        $this->hasBanner = $hasBanner;
    }

    /**
     * Add product
     *
     * @param App\Document\Products $product
     */
    public function addProduct(Products $product)
    {
        $this->products[] = $product;
    }
    /**
     * Remove product
     *
     * @param App\Document\Products $product
     */
    public function removeProduct(Products $product)
    {
        $this->products->removeElement($product);
    }
    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection $products
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /**
     * Add caracteristique
     *
     * @param App\Document\Caracteristiques $caracteristique
     */
    public function addCaracteristique(Caracteristiques $caracteristique)
    {
        $this->caracteristiques[] = $caracteristique;
    }
    /**
     * Remove caracteristique
     *
     * @param App\Document\Caracteristiques $caracteristique
     */
    public function removeCaracteristique(Caracteristiques $caracteristique)
    {
        $this->caracteristiques->removeElement($caracteristique);
    }
    /**
     * Get caracteristiques
     *
     * @return \Doctrine\Common\Collections\Collection $caracteristiques
     */
    public function getCaracteristiques()
    {
        return $this->caracteristiques;
    }
    
    /**
     * @param Categories $categorie
     *
     * @return self
     */
    public function setCategorie(Categories $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }
    
    /**
     * Get categorie
     *
     */
    public function getCategorie()
    {
        return $this->categorie;
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
    
    public function __toString() {
        return $this->getName();
    }
}
