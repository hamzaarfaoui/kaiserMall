<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Marchands
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $nrc;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $matriculeFiscale;
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="Stores", mappedBy="marchand") */
    protected $stores = array();
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="User") */
    protected $user;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**      * @return mixed      */
    public function getNrc()
    {
        return $this->nrc;
    }
    /**      * @param mixed $nrc      */
    public function setNrc($nrc)
    {
        $this->nrc = $nrc;
    }
    
    /**      * @return mixed      */
    public function getMatriculeFiscale()
    {
        return $this->matriculeFiscale;
    }
    /**      * @param mixed $matriculeFiscale      */
    public function setMatriculeFiscale($matriculeFiscale)
    {
        $this->matriculeFiscale = $matriculeFiscale;
    }
    
    /**
     * Add store
     *
     * @param App\Document\Stores $store
     */
    public function addStore(Stores $store)
    {
        $this->stores[] = $store;
    }
    /**
     * Remove store
     *
     * @param App\Document\Stores $store
     */
    public function removeStore(Stores $store)
    {
        $this->stores->removeElement($store);
    }
    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection $stores
     */
    public function getStores()
    {
        return $this->stores;
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
