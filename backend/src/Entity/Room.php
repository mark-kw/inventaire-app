<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $number = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RoomType $type = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $capacityAdults = 1;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $capacityChildren = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?float $nightPrice = 0.00;

    #[ORM\Column(length: 3)]
    private ?string $currency = "XOF";

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'room')]
    private Collection $reservations;

    /**
     * @var Collection<int, HousekeepingLog>
     */
    #[ORM\OneToMany(targetEntity: HousekeepingLog::class, mappedBy: 'room')]
    private Collection $housekeepingLogs;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->housekeepingLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?RoomType
    {
        return $this->type;
    }

    public function setType(?RoomType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCapacityAdults(): ?int
    {
        return $this->capacityAdults;
    }

    public function setCapacityAdults(int $capacityAdults): static
    {
        $this->capacityAdults = $capacityAdults;

        return $this;
    }

    public function getCapacityChildren(): ?int
    {
        return $this->capacityChildren;
    }

    public function setCapacityChildren(int $capacityChildren): static
    {
        $this->capacityChildren = $capacityChildren;

        return $this;
    }

    public function getNightPrice(): ?string
    {
        return $this->nightPrice;
    }

    public function setNightPrice(string $nightPrice): static
    {
        $this->nightPrice = $nightPrice;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRoom($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoom() === $this) {
                $reservation->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HousekeepingLog>
     */
    public function getHousekeepingLogs(): Collection
    {
        return $this->housekeepingLogs;
    }

    public function addHousekeepingLog(HousekeepingLog $housekeepingLog): static
    {
        if (!$this->housekeepingLogs->contains($housekeepingLog)) {
            $this->housekeepingLogs->add($housekeepingLog);
            $housekeepingLog->setRoom($this);
        }

        return $this;
    }

    public function removeHousekeepingLog(HousekeepingLog $housekeepingLog): static
    {
        if ($this->housekeepingLogs->removeElement($housekeepingLog)) {
            // set the owning side to null (unless already changed)
            if ($housekeepingLog->getRoom() === $this) {
                $housekeepingLog->setRoom(null);
            }
        }

        return $this;
    }
}
