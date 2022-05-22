<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\StoresRepository")
 */
class Stores
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
    protected $description;
    
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
     * @Assert\NotBlank(message="Please, upload the store imageCouverture as an imageCouverture file.")
     * @Assert\File(mimeTypes={ "imageCouverture/png","imageCouverture/jpg""imageCouverture/jpeg" })       
     */
    protected $imageCouverture;
    
    /**      
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Please, upload the store imageCouverture as an imageCouverture file.")
     * @Assert\File(mimeTypes={ "imageCouverture/png","imageCouverture/jpg""imageCouverture/jpeg" })       
     */
    protected $logo;
    
    /**      
     * @MongoDB\Field(type="integer") 
     */
    protected $nbrView;
    
    /** @MongoDB\ReferenceMany(targetDocument="Products", mappedBy="store") */
    protected $products;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Marchands", inversedBy="stores") */
    protected $marchand;
    
    /** @MongoDB\ReferenceMany(targetDocument="AdressesStore", mappedBy="store") */
    protected $adressesStore;
    
    /** @MongoDB\ReferenceMany(targetDocument="TelephonesStore", mappedBy="store") */
    protected $telephonesStore;
    
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
    public function getDescription()
    {
        return $this->description;
    }
    /**      * @param mixed $description      */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getImageCouverture()
    {
        return $this->imageCouverture;
    }
    /**      * @param mixed $imageCouverture      */
    public function setImageCouverture($imageCouverture)
    {
        $this->imageCouverture = $imageCouverture;
    }
    
    /**      * @return mixed      */
    public function getLogo()
    {
        return $this->logo;
    }
    /**      * @param mixed $logo      */
    public function setLogo($logo)
    {
        $this->logo = $logo;
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
    
    /**      * @param mixed $nbrView      */
    public function setNbrView($nbrView)
    {
        $this->nbrView = $nbrView;
    }
    
    /**      * @return mixed      */
    public function getNbrView()
    {
        return $this->nbrView;
    }

    /**
     * Add product
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
     * @param App\Document\Products $product
     */
    public function removeProduct(Products $product)
    {
        $this->products->removeElement($product);
    }
    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection $products
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /**
     * @param Marchands $marchand
     *
     * @return self
     */
    public function setMarchand(Marchands $marchand)
    {
        $this->marchand = $marchand;
        return $this;
    }
    
    /**
     * Get marchand
     *
     */
    public function getMarchand()
    {
        return $this->marchand;
    }
    
    /**
     * Add sousCategorie
     *
     * @param App\Document\AdressesStore $sousCategorie
     */
    public function addAdresseStore(AdressesStore $sousCategorie)
    {
        $this->adressesStore[] = $sousCategorie;
    }
    /**
     * Remove sousCategorie
     *
     * @param App\Document\AdressesStore $sousCategorie
     */
    public function removeAdresseStore(AdressesStore $sousCategorie)
    {
        $this->adressesStore->removeElement($sousCategorie);
    }
    /**
     * Get adressesStore
     *
     * @return \Doctrine\Common\Collections\Collection $adressesStore
     */
    public function getAdressesStore()
    {
        return $this->adressesStore;
    }
    
    /**
     * Add telephoneStore
     *
     * @param App\Document\TelephonesStore $telephoneStore
     */
    public function addTelephoneStore(TelephonesStore $telephoneStore)
    {
        $this->telephonesStore[] = $telephoneStore;
    }
    /**
     * Remove telephoneStore
     *
     * @param App\Document\TelephonesStore $telephoneStore
     */
    public function removeTelephoneStore(TelephonesStore $telephoneStore)
    {
        $this->telephonesStore->removeElement($telephoneStore);
    }
    /**
     * Get telephonesStore
     *
     * @return \Doctrine\Common\Collections\Collection $telephonesStore
     */
    public function getTelephonesStore()
    {
        return $this->telephonesStore;
    }
}
