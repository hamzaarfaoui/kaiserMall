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
class Contacts
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    
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
    protected $email;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $message;
    
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
    public function getEmail()
    {
        return $this->email;
    }
    /**      * @param mixed $email      */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**      * @return mixed      */
    public function getMessage()
    {
        return $this->message;
    }
    /**      * @param mixed $message      */
    public function setMessage($message)
    {
        $this->message = $message;
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
}
