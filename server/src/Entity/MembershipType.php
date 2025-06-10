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
    private int $maxPaidSecondaries = 0;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?int $secondaryPrice = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['membership:details'])]
    private ?int $maxFreeSecondaries = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private bool $isActive = false;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private bool $isPublic = false;

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
        ?int $duration = 0,
        ?int $price = 0,
        ?bool $isActive = false,
        ?bool $isPublic = false,
        ?string $description = null,
        ?int $maxPaidSecondaries = 0,
        ?int $secondaryPrice = 0,
        ?int $maxFreeSecondaries = 0,
        ?User $creator = null,
    ) {
        $this->name = $name;
        $this->duration = $duration;
        $this->price = $price;
        $this->description = $description;
        $this->maxPaidSecondaries = $maxPaidSecondaries;
        $this->secondaryPrice = $secondaryPrice;
        $this->maxFreeSecondaries = $maxFreeSecondaries;
        $this->isActive = $isActive;
        $this->isPublic = $isPublic;
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

    public function getMaxPaidSecondaries(): ?int
    {
        return $this->maxPaidSecondaries;
    }

    public function setMaxPaidSecondaries(int $maxPaidSecondaries): static
    {
        $this->maxPaidSecondaries = $maxPaidSecondaries;

        return $this;
    }

    public function getSecondaryPrice(): ?int
    {
        return $this->secondaryPrice;
    }

    public function setSecondaryPrice(int $secondaryPrice): static
    {
        $this->secondaryPrice = $secondaryPrice;

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

    public function getMaxFreeSecondaries(): ?int
    {
        return $this->maxFreeSecondaries;
    }

    public function setMaxFreeSecondaries(?int $maxFreeSecondaries): static
    {
        $this->maxFreeSecondaries = $maxFreeSecondaries;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }
}
