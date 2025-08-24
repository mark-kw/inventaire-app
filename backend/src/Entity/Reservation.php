<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 18)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $guest = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $room = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $arrivalDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $departureDate = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $adults = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $children = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $totalAmount = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $XOF = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $checkoutAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): static
    {
        $this->guest = $guest;

        return $this;
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

    public function getArrivalDate(): ?\DateTimeImmutable
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeImmutable $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeImmutable
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeImmutable $departureDate): static
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(int $adults): static
    {
        $this->adults = $adults;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(int $children): static
    {
        $this->children = $children;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getXOF(): ?\DateTimeImmutable
    {
        return $this->XOF;
    }

    public function setXOF(?\DateTimeImmutable $XOF): static
    {
        $this->XOF = $XOF;

        return $this;
    }

    public function getCheckoutAt(): ?\DateTimeImmutable
    {
        return $this->checkoutAt;
    }

    public function setCheckoutAt(?\DateTimeImmutable $checkoutAt): static
    {
        $this->checkoutAt = $checkoutAt;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}
