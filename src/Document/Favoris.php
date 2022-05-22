<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\KeywordsRepository")
 */
class Favoris
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /** @MongoDB\ReferenceOne(targetDocument="Products") */
    protected $product;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="User") */
    protected $user;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
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
     * @param Users $user
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Get user
     *
     */
    public function getUser()
    {
        return $this->user;
    }
}
