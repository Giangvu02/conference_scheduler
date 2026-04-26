<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $username = null;

    #[ORM\Column(length:255)]
    private ?string $email = null;

    #[ORM\Column(length:255)]
    private ?string $password = null;

    #[ORM\Column(length:50)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy:'user', targetEntity: Registration::class)]
    private Collection $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }
}