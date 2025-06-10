<?php

namespace App\Entity;

use App\Repository\MembershipItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipItemRepository::class)]
#[ORM\Table('membership_items')]
class MembershipItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $starting = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $ending = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'item')]
    private ?Membership $membership = null;

    #[ORM\ManyToOne]
    private ?MembershipType $type = null;

    public function __construct(\DateTimeImmutable $starting, \DateTimeImmutable $ending, MembershipType $type)
    {
        $this->starting = $starting;
        $this->ending = $ending;
        $this->type = $type;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarting(): ?\DateTimeImmutable
    {
        return $this->starting;
    }

    public function setStarting(\DateTimeImmutable $starting): static
    {
        $this->starting = $starting;

        return $this;
    }

    public function getEnding(): ?\DateTimeImmutable
    {
        return $this->ending;
    }

    public function setEnding(?\DateTimeImmutable $ending): static
    {
        $this->ending = $ending;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMembership(): ?Membership
    {
        return $this->membership;
    }

    public function setMembership(?Membership $membership): static
    {
        $this->membership = $membership;

        return $this;
    }

    public function getType(): ?MembershipType
    {
        return $this->type;
    }

    public function setType(?MembershipType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
