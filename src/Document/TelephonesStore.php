<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class TelephonesStore
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $numero;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Stores" ,inversedBy="telephonesStore") */
    protected $store;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**      * @return mixed      */
    public function getNumero()
    {
        return $this->numero;
    }
    /**      * @param mixed $numero      */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
