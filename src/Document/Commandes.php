<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\CommandesRepository")
 */
class Commandes
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /** 
     * @MongoDB\ReferenceOne(targetDocument="User") */
    protected $user;
    
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $status;
    
    /**
     * @MongoDB\Field(type="collection")
     */
    private $facture;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $createdAt;
    
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**      * @return mixed      */
    public function getFacture()
    {
        return $this->facture;
    }
    /**      * @param mixed $facture      */
    public function setFacture($facture)
    {
        $this->facture = $facture;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**      * @param mixed $updatedAt      */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
