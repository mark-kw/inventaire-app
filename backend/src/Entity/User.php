<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $fullName = null;

    #[ORM\Column(length: 160)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $passwordHash = null;


    #[ORM\Column(type: 'string', enumType: UserRole::class)]
    private UserRole $role = UserRole::STAFF;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): static
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_' . $this->role->name];
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
    public function setRole(UserRole $r): self
    {
        $this->role = $r;
        return $this;
    }
}
