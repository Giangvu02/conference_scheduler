<?php

namespace App\Entity;

use App\Repository\SpeakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeakerRepository::class)]
class Speaker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $name = null;

    #[ORM\Column(length:255)]
    private ?string $email = null;

    #[ORM\Column(length:255)]
    private ?string $topic = null;

    #[ORM\Column(type:'text')]
    private ?string $biography = null;

    #[ORM\Column(length:255, nullable:true)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy:'speaker', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getTopic(): ?string { return $this->topic; }
    public function setTopic(string $topic): static { $this->topic = $topic; return $this; }

    public function getBiography(): ?string { return $this->biography; }
    public function setBiography(string $biography): static { $this->biography = $biography; return $this; }

    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(?string $photo): static { $this->photo = $photo; return $this; }
}