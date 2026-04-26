<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $roomName = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(length:255)]
    private ?string $building = null;

    #[ORM\OneToMany(mappedBy:'room', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getRoomName(): ?string { return $this->roomName; }
    public function setRoomName(string $roomName): static { $this->roomName = $roomName; return $this; }

    public function getCapacity(): ?int { return $this->capacity; }
    public function setCapacity(int $capacity): static { $this->capacity = $capacity; return $this; }

    public function getBuilding(): ?string { return $this->building; }
    public function setBuilding(string $building): static { $this->building = $building; return $this; }
}