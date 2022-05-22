<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class AdressesStore
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $rue;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $residence;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $ville;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $gouvernaurat;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $pays;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Stores" ,inversedBy="adressesStore") */
    protected $store;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**      * @return mixed      */
    public function getRue()
    {
        return $this->rue;
    }
    /**      * @param mixed $rue      */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }
    
    /**      * @return mixed      */
    public function getVille()
    {
        return $this->ville;
    }
    /**      * @param mixed $ville      */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }
    
    /**      * @return mixed      */
    public function getGouvernaurat()
    {
        return $this->gouvernaurat;
    }
    /**      * @param mixed $gouvernaurat      */
    public function setGouvernaurat($gouvernaurat)
    {
        $this->gouvernaurat = $gouvernaurat;
    }
    
    /**      * @return mixed      */
    public function getPays()
    {
        return $this->pays;
    }
    /**      * @param mixed $pays      */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }
    
    /**      * @return mixed      */
    public function getResidence()
    {
        return $this->residence;
    }
    /**      * @param mixed $residence      */
    public function setResidence($residence)
    {
        $this->residence = $residence;
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
