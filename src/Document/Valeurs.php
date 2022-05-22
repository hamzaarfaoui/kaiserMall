<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Valeurs
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /** @MongoDB\ReferenceMany(targetDocument="Products", inversedBy="valeurs") */
    protected $products;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Caracteristiques", inversedBy="valeurs") */
    protected $caracteristique = array();
    
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
    
    /**
     * Add articleRevision
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
     * @param App\Document\Article $product
     */
    public function removeProduct(Products $product)
    {
        $this->products->removeElement($product);
    }
    
    /**
     * Get valeurs
     *
     * @return \Doctrine\Common\Collections\Collection $products
     */
    public function getProducts()
    {
        return $this->products;
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
    
    /**
     * @return mixed
     */
    public function getCaracteristique()
    {
        return $this->caracteristique;
    }
    /**
     * @param Caracteristiques $caracteristique
     *
     * @return self
     */
    public function setCaracteristique(Caracteristiques $caracteristique)
    {
        $this->caracteristique = $caracteristique;
        return $this;
    }
    
    public function __toString() {
        return $this->getName();
    }
}
