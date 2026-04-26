<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $title = null;

    #[ORM\Column(type:'date')]
    private ?\DateTimeInterface $sessionDate = null;

    #[ORM\Column(type:'time')]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type:'time')]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(inversedBy:'sessions')]
    private ?Conference $conference = null;

    #[ORM\ManyToOne(inversedBy:'sessions')]
    private ?Speaker $speaker = null;

    #[ORM\ManyToOne(inversedBy:'sessions')]
    private ?Room $room = null;

    #[ORM\OneToMany(mappedBy:'session', targetEntity: Registration::class)]
    private Collection $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }
}