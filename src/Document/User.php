<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $nom;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $prenom;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $photo;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $adress;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $city;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $country;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $adressLivraison;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $cityLivraison;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $countryLivraison;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $phone;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $createdAt;
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;
    
    /**      
     * @MongoDB\Field(type="date")
     */
    protected $dateNaissance;
    
    /** @MongoDB\ReferenceMany(targetDocument="AdressesUser", mappedBy="user") */
    protected $adressesUser;
    
    /** @MongoDB\ReferenceMany(targetDocument="TelephonesUser", mappedBy="user") */
    protected $telephoneUser;
    
    /** @MongoDB\ReferenceOne(targetDocument="TelephonesUser") */
    protected $owner;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**      * @return mixed      */
    public function getNom()
    {
        return $this->nom;
    }
    /**      * @param mixed $nom      */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    /**      * @return mixed      */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**      * @param mixed $prenom      */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }   
    
    /**      * @return mixed      */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**      * @param mixed $photo      */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    
    /**      * @return mixed      */
    public function getAdress()
    {
        return $this->adress;
    }
    /**      * @param mixed $adress      */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }
    
    /**      * @return mixed      */
    public function getAdressLivraison()
    {
        return $this->adressLivraison;
    }
    /**      * @param mixed $adressLivraison      */
    public function setAdressLivraison($adressLivraison)
    {
        $this->adressLivraison = $adressLivraison;
    }
    
    /**      * @return mixed      */
    public function getCity()
    {
        return $this->city;
    }
    /**      * @param mixed $city      */
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    /**      * @return mixed      */
    public function getCityLivraison()
    {
        return $this->cityLivraison;
    }
    /**      * @param mixed $cityLivraison      */
    public function setCityLivraison($cityLivraison)
    {
        $this->cityLivraison = $cityLivraison;
    }
    
    /**      * @return mixed      */
    public function getCountryLivraison()
    {
        return $this->countryLivraison;
    }
    /**      * @param mixed $countryLivraison      */
    public function setCountryLivraison($countryLivraison)
    {
        $this->countryLivraison = $countryLivraison;
    }
    
    /**      * @return mixed      */
    public function getCountry()
    {
        return $this->country;
    }
    /**      * @param mixed $country      */
    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    /**      * @return mixed      */
    public function getPhone()
    {
        return $this->phone;
    }
    /**      * @param mixed $phone      */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
    
    /**      * @return mixed      */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
    /**      * @param mixed $dateNaissance      */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }
    
    /**
     * Add adresseUser
     *
     * @param App\Document\AdressesUser $adresseUser
     */
    public function addAdresseUser(AdressesUser $adresseUser)
    {
        $this->adressesUser[] = $adresseUser;
    }
    /**
     * Remove adresseUser
     *
     * @param App\Document\AdressesUser $adresseUser
     */
    public function removeAdresseUser(AdressesUser $adresseUser)
    {
        $this->adressesUser->removeElement($adresseUser);
    }
    /**
     * Get adresseUser
     *
     * @return \Doctrine\Common\Collections\Collection $adresseUser
     */
    public function getAdressesUser()
    {
        return $this->adresseUser;
    }
    
    /**
     * Add telephoneUser
     *
     * @param App\Document\TelephonesUser $telephoneUser
     */
    public function addTelephoneUser(TelephonesUser $telephoneUser)
    {
        $this->telephonesUser[] = $telephoneUser;
    }
    /**
     * Remove telephoneUser
     *
     * @param App\Document\TelephonesUser $telephoneUser
     */
    public function removeTelephoneUser(TelephonesUser $telephoneUser)
    {
        $this->telephonesUser->removeElement($telephoneUser);
    }
    /**
     * Get telephonesUser
     *
     * @return \Doctrine\Common\Collections\Collection $telephonesUser
     */
    public function getTelephonesUser()
    {
        return $this->telephonesUser;
    }
    
    /**
     * @param User $owner
     *
     * @return self
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        return $this;
    }
    
    /**
     * Get owner
     *
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
