<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Promotions
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
    protected $variable;
    
    /**
     * @MongoDB\Field(type="float")
     */
    protected $fixe;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $status;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $debut;
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $fin;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $createdAt;
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Products") */
    protected $product = array();
    
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
    public function getVariable()
    {
        return $this->variable;
    }
    /**      * @param mixed $variable      */
    public function setVariable($variable)
    {
        $this->variable = $variable;
    }
    
    /**      * @return mixed      */
    public function getFixe()
    {
        return $this->fixe;
    }
    /**      * @param mixed $fixe      */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;
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
    public function getDebut()
    {
        return $this->debut;
    }
    /**      * @param mixed $debut      */
    public function setDebut($debut)
    {
        $this->debut = $debut;
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
    public function getFin()
    {
        return $this->fin;
    }
    /**      * @param mixed $fin      */
    public function setFin($fin)
    {
        $this->fin = $fin;
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
