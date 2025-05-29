<?php

namespace App\Entity;

use App\Repository\MembershipTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'membership_types')]
#[ORM\Entity(repositoryClass: MembershipTypeRepository::class)]
class MembershipType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['membership:details'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['membership:details'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private int $duration = 0;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private int $price = 0;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private int $paid_secondaries = 0;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?int $secondary_price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['membership:details'])]
    private ?int $free_secondaries = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private bool $is_active = false;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private bool $is_public = false;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Membership>
     */
    #[ORM\OneToMany(targetEntity: Membership::class, mappedBy: 'type')]
    private Collection $memberships;

    public function __construct(
        string $name,
        int $duration,
        int $price,
        bool $is_active = false,
        bool $is_public = false,
        ?string $description = null,
        ?int $paid_secondaries = 0,
        ?int $secondary_price = 0,
        ?int $free_secondaries = 0,
        ?User $creator = null,
    ) {
        $this->name = $name;
        $this->duration = $duration;
        $this->price = $price;
        $this->description = $description;
        $this->paid_secondaries = $paid_secondaries;
        $this->secondary_price = $secondary_price;
        $this->free_secondaries = $free_secondaries;
        $this->is_active = $is_active;
        $this->is_public = $is_public;
        $this->createdAt = new \DateTimeImmutable();
        $this->creator = $creator;
        $this->memberships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPaidSecondaries(): ?int
    {
        return $this->paid_secondaries;
    }

    public function setPaidSecondaries(int $paid_secondaries): static
    {
        $this->paid_secondaries = $paid_secondaries;

        return $this;
    }

    public function getSecondaryPrice(): ?int
    {
        return $this->secondary_price;
    }

    public function setSecondaryPrice(int $secondary_price): static
    {
        $this->secondary_price = $secondary_price;

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

    /**
     * @return Collection<int, Membership>
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function addMembership(Membership $membership): static
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships->add($membership);
            $membership->setType($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): static
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getType() === $this) {
                $membership->setType(null);
            }
        }

        return $this;
    }

    public function getFreeSecondaries(): ?int
    {
        return $this->free_secondaries;
    }

    public function setFreeSecondaries(?int $free_secondaries): static
    {
        $this->free_secondaries = $free_secondaries;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): static
    {
        $this->is_public = $is_public;

        return $this;
    }
}
