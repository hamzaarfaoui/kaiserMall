<?php

namespace App\Entity;

use App\Repository\MarchandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarchandsRepository::class)
 */
class Marchands
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
    private $nrc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matriculeFiscale;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Stores::class, mappedBy="marchand")
     */
    private $stores;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNrc(): ?string
    {
        return $this->nrc;
    }

    public function setNrc(?string $nrc): self
    {
        $this->nrc = $nrc;

        return $this;
    }

    public function getMatriculeFiscale(): ?string
    {
        return $this->matriculeFiscale;
    }

    public function setMatriculeFiscale(?string $matriculeFiscale): self
    {
        $this->matriculeFiscale = $matriculeFiscale;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Stores[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Stores $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
            $store->setMarchand($this);
        }

        return $this;
    }

    public function removeStore(Stores $store): self
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
            // set the owning side to null (unless already changed)
            if ($store->getMarchand() === $this) {
                $store->setMarchand(null);
            }
        }

        return $this;
    }
}
