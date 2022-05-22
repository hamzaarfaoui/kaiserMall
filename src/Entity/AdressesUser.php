<?php

namespace App\Entity;

use App\Repository\AdressesUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdressesUserRepository::class)
 */
class AdressesUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $residence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gouvernaurat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /** 
     * @ORM\ManyToOne(targetEntity="User" ,inversedBy="adressesUser") */
    protected $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(?string $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getGouvernaurat(): ?string
    {
        return $this->gouvernaurat;
    }

    public function setGouvernaurat(?string $gouvernaurat): self
    {
        $this->gouvernaurat = $gouvernaurat;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
