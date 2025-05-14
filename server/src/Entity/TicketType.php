<?php

namespace App\Entity;

use App\Repository\TicketTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketTypeRepository::class)]
#[ORM\Table(name: 'ticket_types')]
class TicketType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 2, max: 127)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank, Assert\Length(min: 2, max: 127)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $price = null;

    #[ORM\Column]
    private bool $isActive = false;

    #[ORM\Column]
    private ?bool $isCashier = false;

    #[ORM\Column]
    private ?bool $isPublic = false;

    #[ORM\ManyToOne]
    private User $creator;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, EventType>
     */
    #[ORM\ManyToMany(targetEntity: EventType::class, mappedBy: 'ticketTypes')]
    #[Ignore]
    private Collection $eventTypes;

    #[ORM\Column]
    private bool $isMembersOnly = false;

    public function __construct(
        string $name,
        string $description,
        int $price,
        ?User $creator,
        ?bool $isActive = false,
        ?bool $isCashier = false,
        ?bool $isPublic = false,
        ?bool $isMembersOnly = false,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->isActive = $isActive;
        $this->isCashier = $isCashier;
        $this->isPublic = $isPublic;
        $this->isMembersOnly = $isMembersOnly;
        $this->creator = $creator;

        $this->createdAt = new \DateTimeImmutable();
        $this->eventTypes = new ArrayCollection();
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsCashier(): ?bool
    {
        return $this->isCashier;
    }

    public function setIsCashier(bool $isCashier): static
    {
        $this->isCashier = $isCashier;

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
     * @return Collection<int, EventType>
     */
    public function getEventTypes(): Collection
    {
        return $this->eventTypes;
    }

    public function addEventType(EventType $eventType): static
    {
        if (!$this->eventTypes->contains($eventType)) {
            $this->eventTypes->add($eventType);
            $eventType->addTicketType($this);
        }

        return $this;
    }

    public function removeEventType(EventType $eventType): static
    {
        if ($this->eventTypes->removeElement($eventType)) {
            $eventType->removeTicketType($this);
        }

        return $this;
    }

    public function getIsMembersOnly(): ?bool
    {
        return $this->isMembersOnly;
    }

    public function setIsMembersOnly(bool $isMembersOnly): static
    {
        $this->isMembersOnly = $isMembersOnly;

        return $this;
    }
}
