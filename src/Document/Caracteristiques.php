<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Caracteristiques
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /** @MongoDB\ReferenceMany(targetDocument="Valeurs", mappedBy="caracteristique") */
    protected $valeurs;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="SousCategories", inversedBy="caracteristiques") */
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
    
    /**
     * Add valeur
     *
     * @param App\Document\Valeurs $valeur
     */
    public function addValeur(Valeurs $valeur)
    {
        $this->valeurs[] = $valeur;
    }
    /**
     * Remove valeur
     *
     * @param App\Document\Valeurs $valeur
     */
    public function removeValeur(Valeurs $valeur)
    {
        $this->valeurs->removeElement($valeur);
    }
    /**
     * Get valeurs
     *
     * @return \Doctrine\Common\Collections\Collection $valeurs
     */
    public function getValeurs()
    {
        return $this->valeurs;
    }
    
    /**
     * @param SousCategorie $sousCategorie
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
