<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->adressesUser = new ArrayCollection();
        $this->telephoneUser = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nom;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $prenom;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photo;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $adress;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $adressLivraison;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cityLivraison;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $countryLivraison;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;
    
    /**     
      * @ORM\Column(type="datetime", nullable=true)     
      */
    protected $createdAt;
    /**      
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;
    
    /**      
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateNaissance;

    /** @ORM\OneToMany(targetEntity="AdressesUser", mappedBy="user") */
    protected $adressesUser;
    
    /** @ORM\OneToMany(targetEntity="TelephonesUser", mappedBy="user") */
    protected $telephoneUser;
    
    /** @ORM\ManyToOne(targetEntity="TelephonesUser") */
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
     * @param App\Entity\AdressesUser $adresseUser
     */
    public function addAdresseUser(AdressesUser $adresseUser)
    {
        $this->adressesUser[] = $adresseUser;
    }
    /**
     * Remove adresseUser
     *
     * @param App\Entity\AdressesUser $adresseUser
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
     * @param App\Entity\TelephonesUser $telephoneUser
     */
    public function addTelephoneUser(TelephonesUser $telephoneUser)
    {
        $this->telephonesUser[] = $telephoneUser;
    }
    /**
     * Remove telephoneUser
     *
     * @param App\Entity\TelephonesUser $telephoneUser
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

    public function addAdressesUser(AdressesUser $adressesUser): self
    {
        if (!$this->adressesUser->contains($adressesUser)) {
            $this->adressesUser[] = $adressesUser;
            $adressesUser->setUser($this);
        }

        return $this;
    }

    public function removeAdressesUser(AdressesUser $adressesUser): self
    {
        if ($this->adressesUser->contains($adressesUser)) {
            $this->adressesUser->removeElement($adressesUser);
            // set the owning side to null (unless already changed)
            if ($adressesUser->getUser() === $this) {
                $adressesUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TelephonesUser[]
     */
    public function getTelephoneUser(): Collection
    {
        return $this->telephoneUser;
    }
}