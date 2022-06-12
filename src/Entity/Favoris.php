<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity=Products::class, cascade={"persist", "remove"})
    **/
    protected $product;
    
    /** 
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
     **/
    protected $user;
    
    /**      * @return mixed      */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @param Products $product
     *
     * @return self
     */
    public function setProduct(Products $product)
    {
        $this->product = $product;
        return $this;
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
