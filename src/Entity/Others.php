<?php

namespace App\Entity;

use App\Repository\OthersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OthersRepository::class)
 */
class Others
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $main;

    /**
     * @ORM\Column(type="integer")
     */
    private $liee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain(): ?int
    {
        return $this->main;
    }

    public function setMain(int $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getLiee(): ?int
    {
        return $this->liee;
    }

    public function setLiee(int $liee): self
    {
        $this->liee = $liee;

        return $this;
    }
}
