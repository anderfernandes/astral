<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'events')]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $starting = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ending = null;

    #[ORM\Column]
    private ?bool $isPublic = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\ManyToOne]
    private ?EventType $type = null;

    /**
     * @var Collection<int, Show>
     */
    #[ORM\ManyToMany(targetEntity: Show::class)]
    private Collection $shows;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, EventMemo>
     */
    #[ORM\OneToMany(targetEntity: EventMemo::class, mappedBy: 'event')]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $memos;

    /**
     * @param Show[] $shows
     */
    public function __construct(
        \DateTimeInterface $starting,
        \DateTimeInterface $ending,
        bool $isPublic,
        int $seats,
        EventType $type,
        array $shows = [],
    ) {
        $this->shows = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->memos = new ArrayCollection();

        $this->starting = $starting;
        $this->ending = $ending;
        $this->isPublic = $isPublic;
        $this->seats = $seats;
        $this->type = $type;

        foreach ($shows as $show) {
            $this->addShow($show);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarting(): ?\DateTimeInterface
    {
        return $this->starting;
    }

    public function setStarting(\DateTimeInterface $starting): static
    {
        $this->starting = $starting;

        return $this;
    }

    public function getEnding(): ?\DateTimeInterface
    {
        return $this->ending;
    }

    public function setEnding(\DateTimeInterface $ending): static
    {
        $this->ending = $ending;

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

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): static
    {
        $this->seats = $seats;

        return $this;
    }

    public function getType(): ?EventType
    {
        return $this->type;
    }

    public function setType(?EventType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Show>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): static
    {
        if (!$this->shows->contains($show)) {
            $this->shows->add($show);
        }

        return $this;
    }

    public function removeShow(Show $show): static
    {
        $this->shows->removeElement($show);

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
     * @return Collection<int, EventMemo>
     */
    public function getMemos(): Collection
    {
        return $this->memos;
    }

    public function addMemo(EventMemo $memo): static
    {
        if (!$this->memos->contains($memo)) {
            $this->memos->add($memo);
            $memo->setEvent($this);
        }

        return $this;
    }

    public function removeMemo(EventMemo $memo): static
    {
        if ($this->memos->removeElement($memo)) {
            // set the owning side to null (unless already changed)
            if ($memo->getEvent() === $this) {
                $memo->setEvent(null);
            }
        }

        return $this;
    }
}
