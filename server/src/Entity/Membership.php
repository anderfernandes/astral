<?php

namespace App\Entity;

use App\Enums\MemberPosition;
use App\Repository\MembershipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ORM\Table(name: 'memberships')]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    /**
     * @var Collection<int, Member>
     */
    #[ORM\OneToMany(targetEntity: Member::class, mappedBy: 'membership')]
    private Collection $members;

    public function __construct(?User $creator = null)
    {
        $this->creator = $creator;
        $this->members = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

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

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setMembership($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getMembership() === $this) {
                $member->setMembership(null);
            }
        }

        return $this;
    }

    #[Groups(['membership:details'])]
    public function getPrimary(): ?Member
    {
        foreach ($this->members as $member) {
            if (MemberPosition::PRIMARY === $member->getPosition()) {
                return $member;
            }
        }

        return null;
    }

    /**
     * @return Member[]
     */
    public function getSecondaries(?MemberPosition $secondaryPosition = null): array
    {
        /** @var Member[] */
        $secondaries = [];

        foreach ($this->members as $member) {
            if (null === $secondaryPosition) {
                if (MemberPosition::PRIMARY !== $member->getPosition()) {
                    $secondaries[] = $member;
                }
            } else {
                if ($secondaryPosition === $member->getPosition()) {
                    $secondaries[] = $member;
                }
            }
        }

        return $secondaries;
    }

    /** @return Member[] */
    public function getFreeSecondaries(): array
    {
        /** @var Member[] */
        $secondaries = [];

        foreach ($this->members as $member) {
            if (MemberPosition::FREE_SECONDARY === $member->getPosition()) {
                $secondaries[] = $member;
            }
        }

        return $secondaries;
    }

    /** @return User[] */
    public function getPaidSecondaries(): array
    {
        /** @var User[] */
        $secondaries = [];

        foreach ($this->members as $member) {
            if (MemberPosition::PAID_SECONDARY === $member->getPosition()) {
                $secondaries[] = $member->getUser();
            }
        }

        return $secondaries;
    }

    #[Groups(['membership:details'])]
    public function getType(): MembershipType
    {
        return $this->getPrimary()->getType();
    }
}
