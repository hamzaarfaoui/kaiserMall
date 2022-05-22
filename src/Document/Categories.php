<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Categories
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
     * @Assert\NotBlank(message="Please, upload the Article image as an image file.")
     * @Assert\File(mimeTypes={ "image/png","image/jpg""image/jpeg" })       
     */
    protected $icone;
    
    /** @MongoDB\ReferenceMany(targetDocument="SousCategories", mappedBy="categorie") */
    protected $sousCategories;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="CategoriesMere", inversedBy="categories") */
    protected $categorieMere;
    
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
    public function getIcone()
    {
        return $this->icone;
    }
    /**      * @param mixed $icone      */
    public function setIcone($icone)
    {
        $this->icone = $icone;
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
     * Add sousCategorie
     *
     * @param App\Document\SousCategories $sousCategorie
     */
    public function addSousCategorie(SousCategories $sousCategorie)
    {
        $this->sousCategories[] = $sousCategorie;
    }
    /**
     * Remove sousCategorie
     *
     * @param App\Document\SousCategories $sousCategorie
     */
    public function removeSousCategorie(SousCategories $sousCategorie)
    {
        $this->sousCategories->removeElement($sousCategorie);
    }
    /**
     * Get sousCategories
     *
     * @return \Doctrine\Common\Collections\Collection $sousCategories
     */
    public function getSousCategories()
    {
        return $this->sousCategories;
    }
    
    /**
     * @param Categories $categorieMere
     *
     * @return self
     */
    public function setCategorieMere(CategoriesMere $categorieMere)
    {
        $this->categorieMere = $categorieMere;
        return $this;
    }
    
    /**
     * Get categorieMere
     *
     */
    public function getCategorieMere()
    {
        return $this->categorieMere;
    }
    
    public function __toString() {
        return $this->getName();
    }
}
