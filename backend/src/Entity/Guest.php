<?php

namespace App\Entity;

use App\Repository\GuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Annotation\Ignore;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
#[ApiResource(operations: [new Get(), new GetCollection(), new Post(), new Patch(), new Delete()])]
#[ApiFilter(SearchFilter::class, properties: [
    'firstName' => 'ipartial',
    'lastName' => 'ipartial',
    'email' => 'ipartial',
    'phone' => 'ipartial',
    'nationality' => 'ipartial'
])]
#[ApiFilter(OrderFilter::class, properties: ['lastName', 'firstName', 'id'])]
class Guest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 80)]
    private ?string $firstName = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 80)]
    private ?string $lastName = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 160, nullable: true)]
    private ?string $email = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 40, nullable: true)]
    private ?string $phone = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 40, nullable: true)]
    private ?string $idType = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(length: 80, nullable: true)]
    private ?string $idNumber = null;

    #[Groups(['reservation:read'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $specialRequests = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'guest')]
    #[Ignore]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getIdType(): ?string
    {
        return $this->idType;
    }

    public function setIdType(?string $idType): static
    {
        $this->idType = $idType;

        return $this;
    }

    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    public function setIdNumber(?string $idNumber): static
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    public function getSpecialRequests(): ?string
    {
        return $this->specialRequests;
    }

    public function setSpecialRequests(?string $specialRequests): static
    {
        $this->specialRequests = $specialRequests;

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
            $reservation->setGuest($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getGuest() === $this) {
                $reservation->setGuest(null);
            }
        }

        return $this;
    }
}
