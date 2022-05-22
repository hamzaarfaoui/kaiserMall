<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Banners
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $image;
    
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $status;
    
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $isTwo;
    
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $isThree;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Products") */
    protected $product;
 
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
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
    public function getStatus()
    {
        return $this->status;
    }
    /**      * @param mixed $status      */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**      * @return mixed      */
    public function getIsTwo()
    {
        return $this->isTwo;
    }
    /**      * @param mixed $isTwo      */
    public function setIsTwo($isTwo)
    {
        $this->isTwo = $isTwo;
    }
    
    /**      * @return mixed      */
    public function getIsThree()
    {
        return $this->isThree;
    }
    /**      * @param mixed $isThree      */
    public function setIsThree($isThree)
    {
        $this->isThree = $isThree;
    }
    
    
    
    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @param Products $product
     *
     * @return self
     */
    public function setProduct(Products $product)
    {
        $this->product = $product;
        return $this;
    }
}
