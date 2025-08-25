<?php

namespace App\Entity;


use App\Enum\MaintenanceStatus;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;


#[ORM\Entity]
#[ORM\Table(name: 'maintenance_tasks')]
#[ApiResource(operations: [new Get(), new GetCollection(), new Post(), new Patch()])]
#[ApiFilter(SearchFilter::class, properties: [
    'room'      => 'exact',
    'status'    => 'exact', // enum
    'createdBy' => 'exact',
    'title'     => 'ipartial'
])]
#[ApiFilter(DateFilter::class, properties: ['createdAt', 'resolvedAt'])]
#[ApiFilter(OrderFilter::class, properties: ['status', 'createdAt'])]
class MaintenanceTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'maintenanceTasks')]
    private ?Room $room = null;


    #[ORM\Column(length: 160)]
    private string $title;


    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;


    #[ORM\Column(type: 'string', enumType: MaintenanceStatus::class)]
    private MaintenanceStatus $status = MaintenanceStatus::OPEN;


    #[ORM\ManyToOne]
    private ?User $createdBy = null;


    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;


    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $resolvedAt = null;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getRoom(): ?Room
    {
        return $this->room;
    }
    public function setRoom(?Room $r): self
    {
        $this->room = $r;
        return $this;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $t): self
    {
        $this->title = $t;
        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $d): self
    {
        $this->description = $d;
        return $this;
    }
    public function getStatus(): MaintenanceStatus
    {
        return $this->status;
    }
    public function setStatus(MaintenanceStatus $s): self
    {
        $this->status = $s;
        return $this;
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function setCreatedBy(?User $u): self
    {
        $this->createdBy = $u;
        return $this;
    }
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeImmutable $dt): self
    {
        $this->createdAt = $dt;
        return $this;
    }
    public function getResolvedAt(): ?\DateTimeImmutable
    {
        return $this->resolvedAt;
    }
    public function setResolvedAt(?\DateTimeImmutable $dt): self
    {
        $this->resolvedAt = $dt;
        return $this;
    }
}
