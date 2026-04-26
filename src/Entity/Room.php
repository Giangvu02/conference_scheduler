<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Tên phòng không được để trống")]
    private ?string $roomName = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Vui lòng nhập sức chứa")]
    #[Assert\Positive(message: "Sức chứa phải là số dương")]
    private ?int $capacity = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Vui lòng nhập tên tòa nhà")]
    private ?string $building = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomName(): ?string
    {
        return $this->roomName;
    }

    public function setRoomName(string $roomName): static
    {
        $this->roomName = $roomName;
        return $this;
    }

    /**
     * Dùng cho Twig hoặc hiển thị chung
     */
    public function getName(): ?string
    {
        return $this->roomName;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function setBuilding(string $building): static
    {
        $this->building = $building;
        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setRoom($this);
        }
        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            if ($session->getRoom() === $this) {
                $session->setRoom(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->roomName;
    }
}