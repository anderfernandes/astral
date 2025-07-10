<?php

namespace App\Entity;

use App\Enums\MemberPosition;
use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'members')]
#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('membership:details')]
    #[ORM\Column(enumType: MemberPosition::class)]
    private ?MemberPosition $position = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membership $membership = null;

    #[Groups('membership:details')]
    #[ORM\Column]
    private ?\DateTimeImmutable $starting = null;

    #[Groups('membership:details')]
    #[ORM\Column]
    private ?\DateTimeImmutable $ending = null;

    #[Groups('membership:details')]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MembershipType $type = null;

    #[Groups('membership:details')]
    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct(MembershipType $type, User $user, \DateTimeImmutable $starting)
    {
        $this->type = $type;
        $this->user = $user;
        $this->starting = $starting;

        $duration = $type->getDuration();

        $this->ending = $starting->modify("+$duration days");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?MemberPosition
    {
        return $this->position;
    }

    public function setPosition(MemberPosition $position): static
    {
        $this->position = $position;

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

    public function setEnding(\DateTimeImmutable $ending): static
    {
        $this->ending = $ending;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
