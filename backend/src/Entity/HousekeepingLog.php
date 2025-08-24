<?php

namespace App\Entity;

use App\Enum\RoomStatus;
use App\Repository\HousekeepingLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousekeepingLogRepository::class)]
class HousekeepingLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'housekeepingLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $room = null;


    #[ORM\Column(type: 'string', enumType: RoomStatus::class, nullable: true)]
    private ?RoomStatus $statusFrom = null;


    #[ORM\Column(type: 'string', enumType: RoomStatus::class)]
    private RoomStatus $statusTo;


    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $note = null;


    #[ORM\ManyToOne]
    private ?User $changedBy = null;


    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $changedAt;


    public function __construct()
    {
        $this->changedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }
    public function getStatusFrom(): ?RoomStatus
    {
        return $this->statusFrom;
    }
    public function setStatusFrom(?RoomStatus $s): self
    {
        $this->statusFrom = $s;
        return $this;
    }
    public function getStatusTo(): RoomStatus
    {
        return $this->statusTo;
    }
    public function setStatusTo(RoomStatus $s): self
    {
        $this->statusTo = $s;
        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }
    public function setNote(?string $n): self
    {
        $this->note = $n;
        return $this;
    }
    public function getChangedBy(): ?User
    {
        return $this->changedBy;
    }
    public function setChangedBy(?User $u): self
    {
        $this->changedBy = $u;
        return $this;
    }
    public function getChangedAt(): \DateTimeImmutable
    {
        return $this->changedAt;
    }
    public function setChangedAt(\DateTimeImmutable $dt): self
    {
        $this->changedAt = $dt;
        return $this;
    }
}
