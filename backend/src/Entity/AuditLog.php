<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'audit_logs')]
#[ORM\Index(columns: ['entity', 'entity_id'], name: 'idx_audit_entity')]
class AuditLog
{
    // Note: BIGINT est mappé en string par défaut pour compat PHP 32/64
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?string $id = null;


    #[ORM\ManyToOne]
    private ?User $actor = null;


    #[ORM\Column(length: 60)]
    private string $entity;


    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $entityId = null; // UUID string


    #[ORM\Column(length: 40)]
    private string $action;


    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $payload = null;


    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getId(): ?string
    {
        return $this->id;
    }
    public function getActor(): ?User
    {
        return $this->actor;
    }
    public function setActor(?User $u): self
    {
        $this->actor = $u;
        return $this;
    }
    public function getEntity(): string
    {
        return $this->entity;
    }
    public function setEntity(string $e): self
    {
        $this->entity = $e;
        return $this;
    }
    public function getEntityId(): ?string
    {
        return $this->entityId;
    }
    public function setEntityId(?string $id): self
    {
        $this->entityId = $id;
        return $this;
    }
    public function getAction(): string
    {
        return $this->action;
    }
    public function setAction(string $a): self
    {
        $this->action = $a;
        return $this;
    }
    public function getPayload(): ?array
    {
        return $this->payload;
    }
    public function setPayload(?array $p): self
    {
        $this->payload = $p;
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
}
