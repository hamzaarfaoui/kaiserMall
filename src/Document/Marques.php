<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Marques
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
     */
    protected $video;
    
    /** @MongoDB\ReferenceMany(targetDocument="Products", mappedBy="marque") */
    protected $products;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="SousCategories") */
    protected $sousCategorie;
    
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
    public function getVideo()
    {
        return $this->video;
    }
    /**      * @param mixed $video      */
    public function setVideo($video)
    {
        $this->video = $video;
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

}
