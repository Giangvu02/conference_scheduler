<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:'date')]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\Column(length:50)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy:'registrations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy:'registrations')]
    private ?Session $session = null;
}