<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\PaymentMethod;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;


#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ApiResource(operations: [new Get(), new GetCollection(), new Post(), new Patch(), new Delete()])]
#[ApiFilter(SearchFilter::class, properties: [
    'reservation' => 'exact', // IRI /api/reservations/{id}
    'method'      => 'exact', // enum
    'reference'   => 'ipartial'
])]
#[ApiFilter(DateFilter::class, properties: ['paidAt'])]
#[ApiFilter(OrderFilter::class, properties: ['paidAt', 'amount'])]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $reservation = null;

    #[ORM\Column(type: 'string', enumType: PaymentMethod::class)]
    private PaymentMethod $method;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $amount;

    #[ORM\Column(length: 3)]
    private ?string $currency = 'XOF';

    #[ORM\Column(length: 120)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $paidAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $r): self
    {
        $this->reservation = $r;
        return $this;
    }

    public function getMethod(): PaymentMethod
    {
        return $this->method;
    }

    public function setMethod(PaymentMethod $m): self
    {
        $this->method = $m;
        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeImmutable $paidAt): static
    {
        $this->paidAt = $paidAt;

        return $this;
    }
}
