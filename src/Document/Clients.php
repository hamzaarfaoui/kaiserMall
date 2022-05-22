<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Clients
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /** 
     * @MongoDB\ReferenceOne(targetDocument="User") */
    protected $user;
    
    
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
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
