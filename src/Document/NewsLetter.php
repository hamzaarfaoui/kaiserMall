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
class NewsLetter
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;
    
    /**     
      * @MongoDB\Field(type="date")     
      */
    protected $createdAt;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**      * @param mixed $createdAt      */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
